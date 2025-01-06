<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\General\FileExtentionCheckRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{

    /**
     * get all user
     * @return View
     */
    public function index(): View
    {
        $title = "Manage User";
        $users = User::latest()->get();
        return view('admin.user.index', compact('title', 'users'));
    }

    /**
     * create a new user
     * @return View
     */
    public function create() : View
    {        
        $title = "Create User";
        return view('admin.user.create', compact('title'));
    }

    /**
     * stroe a user 
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request) :RedirectResponse
    {

        $this->validate($request, [
            
            'name'     => 'required|max:255',
            'email'    => 'required|max:255|unique:users,email',
            'phone'    => 'required|max:100|unique:users,phone',
            'whatsapp_number' => 'required|max:100',
            'city'     => 'required|max:255',
            'cnss'     => 'required|max:255',
            'garage_name' => 'required|max:255',
            'traning_type' => 'required|max:255',
            'traning' => 'required|max:255',
            'status'   =>'required',
            'password' => 'required|confirmed|min:5',
            'image'    =>[new FileExtentionCheckRule(json_decode(site_settings('mime_types'),true))],
            'address'  =>  Rule::requiredIf(site_settings("auto_ticket_assignment") == (StatusEnum::true)->status() && site_settings('geo_location') == 'map_base')
        ],
        [
            'name.required'      => translate('User Name Feild Is Required'),
            'email.required'     => translate('Email Feild Is Required'),
            'email.unique'       => translate('Email Feild Must Be Unique'),
            'phone.required'     => translate('Phone Feild Is Required'),
            'phone.unique'       => translate('Phone Feild Must Be Unique'),
            'whatsapp_number.required' => translate('Whatsapp Number Feild Is Required'),
            'city.required'      => translate('Select Your City'),
            'cnss.required'      => translate('CNSS Feild Is Required'),
            'cnss.unique'        => translate('CNSS Number Must Be Unique'),
            'garage_name.required' => translate('CNSS Number Must Be Unique'),
            'traning_type.required'      => translate('Select Training Type'),
            'traning.required'      => translate('Select Training'),
            'city.required'      => translate('Select Your City'),
            'status.required'    => translate('Please Select A Status'),
            'password'           => translate('Password Feild Is Required'),
            'password.confirmed' => translate('Confirm Password Does not Match'),
            'password.min'       => translate('Minimum 5 digit or character is required'),
            'address.required'   => translate('Select Your Address'),

        ]);

        
        $address_data    =  (new AgentController())->get_address($request);
        $user            =  new User();
        $user->name      =  $request->name;
        $user->email     =  $request->email;
        $user->phone     =  $request->phone;
        $user->whatsapp_number = $request->whatsapp_number;
        $user->city = $request->city;
        $user->cnss = $request->cnss;
        $user->garage_name = $request->garage_name;
        $user->revenue = $request->revenue;
        $user->training_type = $request->traning_type;
        $user->training = $request->traning;
        $user->status    =  $request->status;
        $user->password  = Hash::make($request->password);
        $user->address   =  json_encode($address_data);
        $user->longitude =  isset($address_data['lon']) ?  $address_data['lon'] : null;
        $user->latitude	 =  isset($address_data['lat']) ?  $address_data['lat'] : null;

        if($request->hasFile('image')){
            try{
                $removefile  =  null;
                $user->image = storeImage($request->image, getFilePaths()['profile']['user']['path'], getFilePaths()['profile']['user']['size'], $removefile);
            }catch (\Exception $exp){
                    return back()->with('error', translate("Unable to upload file. Check directory permissions"));
                }
            }

        $user->save();
        
        if(site_settings('default_notification') == (StatusEnum::true)->status()){
            set_default_notifications($user);
        }
        return back()->with('success', translate("User Created Successfully"));

    }

    /**
     * edit a user 
     * 
     * @param int|string $id
     * @return  View
     */
    public function edit(int |string $id) :View
    {
       $title ='update user';
       $user  = User::where('id',$id)->first();
       return view('admin.user.edit', compact('title', 'user'));
    }

    /**
     * update a user 
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request) :RedirectResponse
    {

        $this->validate($request, [
            'name'    => 'required|max:255',
            'email'   => 'required|max:255|unique:users,email,'.request()->id,
            'phone'   => 'required|max:100|unique:users,phone,'.request()->id,
            'image'   => [new FileExtentionCheckRule(json_decode(site_settings('mime_types'),true))],
            'address' =>  Rule::requiredIf(site_settings("auto_ticket_assignment") == '1' && site_settings('geo_location') == 'map_base'),
        ],
        [
            'name.required'    => translate('User Name Feild Is Required'),
            'email.required'   => translate('Email Feild Is Required'),
            'email.unique'     => translate('Email Feild Must Be Unique'),
            'phone.required'   => translate('Phone Feild Is Required'),
            'phone.unique'     => translate('Phone Feild Must Be Unique'),
            'address.required' => translate('Select Your Address'),

        ]);
        $address_data    =  (new AgentController())->get_address($request);
        $user            =  User::where('id',request()->id)->first();
        $user->name      =  $request->name;
        $user->email     =  $request->email;
        $user->phone     =  $request->phone;
        $user->address   =  json_encode($address_data);
        $user->longitude =  isset($address_data['lon']) ?  $address_data['lon'] : null;
        $user->latitude	 =  isset($address_data['lat']) ?  $address_data['lat'] : null;

        if($request->hasFile('image')){

            try{
                $removefile  = $user->image ?: null;
                $user->image = storeImage($request->image, getFilePaths()['profile']['user']['path'], getFilePaths()['profile']['user']['size'], $removefile);
            }catch (\Exception $exp){
                return back()->with('error', translate("Unable to upload file. Check directory permissions"));
            }
        }
        $user->save();
        return back()->with('success', translate("User Updated Successfully"));

    }

    /**
     * delete a user function
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Request $request):RedirectResponse
    {
       $user  = User::where('id',$request->id)->first();
       
       try {
          remove_file(getFilePaths()['profile']['user']['path'], $user->image);
        } catch (\Throwable $th) {

        }
       $user->delete();
       return back()->with('success', translate("User Deleted Successfully"));
    }

    /**
     * user login
     * 
     * @param $request
     * @return  string
     */
     public function statusUpdate(Request $request) :string{

    
        $modelInfo = [
            'table'  => (new User())->getTable(),
            'key'    => "id",
            'values' => StatusEnum::toArray()
        ];
        validateModelStatus($request,$modelInfo);

        User::where('id',$request->data['id'])->update([
            'status' => $request->data['status']
        ]);

        $response['status']  = true;
        $response['reload']  = true;
        $response['message'] = translate('Status Updated Successfully');

        return json_encode($response);
    }

    /**
     * user login
     * 
     * @param int|string $id
     * @return RedirectResponse
     */
     public function login(int | string $id) :RedirectResponse {

        $message = translate('User Not Found');
        $user    =  User::where('id',$id)->first();
        if($user){
            if($user->status    == (StatusEnum::true)->status()){
                $user->verified = (StatusEnum::true)->status();
                $user->save();
                Auth::guard('web')->loginUsingId($user->id);
                return redirect()->route('user.dashboard')
                ->with('success',translate('SuccessFully Login As a User'));
            }
            $message = translate('Active User Status Then Try Again');
        }
        return back()->with('error',  $message);
    }



    /**
     * Update password
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function passwordUpdate(Request $request): RedirectResponse{

        $request->validate([
            'id'       => 'required|exists:users,id',
            'password' => 'required|confirmed|min:5'
        ]
        ,[
            'id.required'        => translate('Invalid user'),
            'id.exists'          => translate('Invalid user'),
            'password'           => translate('Password Feild Is Required'),
            'password.confirmed' => translate('Confirm Password Does not Match'),
            'password.min'       => translate('Minimum 5 digit or character is required'),


        ]);
        $user =  User::findOrfail($request->input('id'));
        $user->password  = Hash::make($request->password);
        $user->save();
        return back()->with("success", translate('Password updated'));
    }
    
    
    
    /**
     * Get Clients By Training Type
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function trainingClients(Request $request, $training_type)
    {
        $users = User::all();
        return view('admin.dashboard')->with($users);
    }

    


}
