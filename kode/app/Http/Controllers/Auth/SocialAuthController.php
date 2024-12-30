<?php

namespace App\Http\Controllers\Auth;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Services\Admin\DepartmentService;
use App\Models\Department;
use App\Models\User;
use App\Traits\EnvatoManager;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    use EnvatoManager;


    /**
     * socail auth redirect function
     *
     * @param Request $request
     * @param $service
     * @return void
     */
    public function redirectToOauth(string $service)
    {
        return $service === 'envato' ? $this->redirectToEnvatoOauth() : Socialite::driver($service)->redirect();
    }

    private function redirectToEnvatoOauth() {
        
        $client_id    = json_decode(site_settings('social_login'), true)['envato_oauth']['client_id'] ?? null;
        $redirect_uri = route('social.login.callback', 'envato');
        $state        = Str::random(40);
        session(['envato_oauth_state' => $state]);
        return $this->oAuthAuthentication($client_id, $redirect_uri, $state);
    }

    /**
     * handle o auth call back
     *
     * @param $service
     * @return void
     */
    public function handleOauthCallback(Request $request, string $service) : \Illuminate\Http\RedirectResponse
    {
        try {
            if ($service === 'envato') {

                return $this->handleEnvatoCallback($request);
            }
            $userOauth = Socialite::driver($service)->stateless()->user();
        } catch (\Exception $e) {
            return back()->with('error',translate('Setup Your Social Credentail!! Then Try Agian'));
        }

        $user = User::where('email',$userOauth->email)->first();
        
        if(!$user){
            
            $address_data =  get_ip_info();
            $userAgent   = request()->header('User-Agent');
            $address_data ['browser_name'] = browser_name($userAgent);
            $address_data ['device_name'] = get_divice_type($userAgent);
            $user  = new User();
            $user->name = $userOauth->user['name'];
            $user->image = @$userOauth->avatar;
            $user->email = $userOauth->user['email'];
            $user->o_auth_id = $userOauth->user['id'];

            $user->status        =  (StatusEnum::true)->status();
            $user->verified      =  (StatusEnum::true)->status();
            $user->address       =  json_encode($address_data);
            $user->longitude	 =  isset($address_data['lon']) ?  $address_data['lon'] : null;
            $user->latitude	     =  isset($address_data['lat']) ?  $address_data['lat'] : null;
            $user->save();

            if(site_settings('default_notification') == (StatusEnum::true)->status()){
                set_default_notifications($user);
            }
        }
        else{
            $user->image = @$userOauth->avatar;
            $user->save();
        }
        
        Auth::guard('web')->login($user);
        return redirect()->route('user.dashboard')->with('success',translate('Login Success'));
    }

    /**
     * Handle Envato OAuth callback
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    private function handleEnvatoCallback(Request $request) {

        $code = $request->get('code');
        if ($request->state !== session('envato_oauth_state') || !$code) {
            return back()->with('error', translate('Invalid Authentication Request'));
        }
        $client_id     = json_decode(site_settings('social_login'), true)['envato_oauth']['client_id'] ?? null;
        $client_secret = json_decode(site_settings('social_login'), true)['envato_oauth']['client_secret'] ?? null;;
        $redirect_uri  = route('social.login.callback', 'envato');
        $access_token  = $this->getUserAccessToken($code, $client_id, $client_secret);
        $user_name_response    = $this->getUserName($access_token);
        $user_email_response   = $this->getUserEmailAddress($access_token);
        $user_details_response = $this->getUserDetails($access_token);
        if(empty($user_name_response) || empty($user_email_response) || empty($user_details_response)) {
            return back()->with('error', translate('Failed to fetch user details from Envato'));
        }
        $user = $this->addEnvatoUser($user_name_response['username'], $user_email_response['email'], $user_details_response['account']);
        if($user) {
            
            $user = $this->storeEnvatoPurchases($user, $access_token);
            Auth::guard('web')->login($user);
            return redirect()->route('user.dashboard')->with('success', translate('Login Success'));
        } else {

            return back()->with('error', translate('Something went wrong'));
        }
        
    }

    private function addEnvatoUser($username, $email, $details) {

        try {
            $address_data = get_ip_info();
            $userAgent = request()->header('User-Agent');
            $address_data['browser_name'] = browser_name($userAgent);
            $address_data['device_name'] = get_divice_type($userAgent);
    
            $userData = [
                'name' => $username,
                'email' => $email,
                'image' => Arr::get($details, 'image'),
                'status' => StatusEnum::true->status(),
                'verified' => StatusEnum::true->status(),
                'address' => json_encode($address_data),
                'longitude' => Arr::get($address_data, 'lon'),
                'latitude' => Arr::get($address_data, 'lat'),
            ];
    
            $user = User::updateOrCreate(
                ['o_auth_id' => $username],
                $userData
            );
    
            if (site_settings('default_notification') == StatusEnum::true->status()) {
                set_default_notifications($user);
            }
    
            return $user;
        } catch (\Exception $e) {
            \Log::error('Error in addEnvatoUser: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * @param User $user
     * @param string $access_token
     */
    private function storeEnvatoPurchases(User $user, string $access_token) {

        $response = $this->getUserPurchaseList($access_token);
        if (!$response->successful()) { 

            return; 
        }
    
        $purchases  = Arr::get($response->json(), 'results', []);
        $formattedPurchases = [];
        foreach ($purchases as $purchase) {
            $purchaseCode      = Arr::get($purchase, 'code');
            $formattedPurchase = [
                'envato_item_id' => Arr::get($purchase, 'item.id'),
                'product_name'   => Arr::get($purchase, 'item.name'),
                'sold_at'   => Arr::get($purchase, 'sold_at'),
                'license'   => Arr::get($purchase, 'license'),
                'supported_until'   => Arr::get($purchase, 'supported_until'),
                'purchase_code'  => $purchaseCode,
            ];
           
            $formattedPurchases[] = $formattedPurchase;
        }
        $user->envato_purchases = $formattedPurchases;
        $user->save();
        return $user;
    }
}
