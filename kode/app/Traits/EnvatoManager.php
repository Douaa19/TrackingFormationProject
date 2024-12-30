<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

trait EnvatoManager {

    private string $businessAccountApiEndpoint     = "https://api.envato.com/v1/market/private/user/account.json";
    private string $businessUsernameApiEndpoint    = "https://api.envato.com/v1/market/private/user/username.json";
    private string $businessEmailApiEndpoint       = "https://api.envato.com/v1/market/private/user/email.json";
    private string $verifyPurchaseApiEndpoint      = "https://api.envato.com/v3/market/author/sale";
    private string $autherItemsApiEndpoint         = "https://api.envato.com/v1/discovery/search/search/item";
    private string $userPurchasesApiEndpoint       = "https://api.envato.com/v3/market/buyer/list-purchases";
    private string $oAuthAuthenticationApiEndpoint = "https://api.envato.com/authorization";
    private string $userAccessTokenApiEndpoint     = "https://api.envato.com/token";

    /**
     * Summary of oAuthAuthentication
     * @param string $client_id
     * @param string $redirect_uri
     * @param string $state
     * @return array
     */
    public function oAuthAuthentication(string $client_id, string $redirect_uri, string $state) {
		
        $queryParams = http_build_query([
            'response_type' => 'code',
            'client_id'     => $client_id,
            'redirect_uri'  => $redirect_uri,
            'state'         => $state,
            'scope'         => 'user:username user:email sale:verify'
        ]);
        return redirect($this->oAuthAuthenticationApiEndpoint . '?' . $queryParams);
    }
    
    /**
     * Summary of getUserDetails
     * @param string $access_token
     * @return array
     */
    public function getUserName(string $access_token): array{

        $response = Http::withToken($access_token)->get($this->businessUsernameApiEndpoint);
        return $response->json();
    }
    /**
     * Summary of getUserDetails
     * @param string $access_token
     * @return array
     */
    public function getUserEmailAddress(string $access_token): array{

        $response = Http::withToken($access_token)->get($this->businessEmailApiEndpoint);
        return $response->json();
    }
    /**
     * Summary of getUserDetails
     * @param string $access_token
     * @return array
     */
    public function getUserDetails(string $access_token): array{

        $response = Http::withToken($access_token)->get($this->businessAccountApiEndpoint);
        return $response->json();
    }

    /**
     * Summary of getUserPurchaseList
     * @param string $access_token
     */
    public function getUserPurchaseList(string $access_token) {

        $response = Http::withToken($access_token)->get($this->userPurchasesApiEndpoint);
        return $response;
    }

    /**
     * Summary of getUserAccessToken
     * @param string $code
     * @param string $client_id
     * @param string $client_secret
     * @return string
     */
    public function getUserAccessToken(string $code, string $client_id, string $client_secret) {

        $response = Http::asForm()->post($this->userAccessTokenApiEndpoint, [
            'grant_type'    => 'authorization_code',
            'code'          => $code,
            'client_id'     => $client_id,
            'client_secret' => $client_secret,
        ]);
        if (!$response->successful()) {
            return back()->with('error', translate('Failed to authenticate with Envato: ') . $response->body());
        }
        return $response->json('access_token');
    }

    /**
     * Summary of getEnvatoBusinessAcount
     * @param string $personal_token
     * @return array
     */
    public function getEnvatoBusinessAcount(string $personal_token): array{

        $response = Http::withToken($personal_token)->get($this->businessAccountApiEndpoint);
        $payload = $response->json();

        if($response->successful()) {
            $payload['personal_token'] = $personal_token;
            $payload['status']      = true;
            return $payload;
        }

        return [
            'status'  => false,
            'message' => Arr::get($payload, 'error', translate('Invalid access token')),
        ];
    }

    /**
     * Summary of Items
     * @param string $username
     * @param string $personal_token
     * @return array
     */
    public function getAuthorItems(string $username, string $personal_token): array{

        $response = Http::withToken($personal_token)->get($this->autherItemsApiEndpoint, [
            'username' => $username
        ]);
        $payload = $response->json();

        if($response->successful()) {
            $payload['personal_token'] = $personal_token;
            $payload['status']      = true;
            return $payload;
        }

        return [
            'status'  => false,
            'message' => Arr::get($payload, 'error', translate('Invalid data')),
        ];
    }




    /**
     * Summary of verifyPurchase
     * @param string $purchaseCode
     * @param string $personal_token
     * @return array
     */
    public function verifyPurchase(string $purchaseCode , string $personal_token): array{

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$personal_token,
            'User-Agent' => 'Purchase code verification',
        ])->get($this->verifyPurchaseApiEndpoint, [
            'code' => $purchaseCode,
        ]);
        
        $payload = $response->json();
        if($response->successful()) {

            $payload['purchase_key'] = $purchaseCode;
            $payload['status']       = true;
            return $payload;
        }
        $data = [
            'status'  => false,
            'message' => translate('Invalid purchase key'),
        ];
        return $data;
    }

    /**
     * Fetch and verify user purchases
     * @param string $accessToken 
     * @param string $personal_token 
     * @return array
     */
    public function fetchAndVerifyUserPurchases(string $accessToken, string $personal_token): array {
       
        $businessAccount = $this->getEnvatoBusinessAcount($personal_token);
        if (!$businessAccount['status']) {
            return [
                'status' => false,
                'message' => 'Invalid personal token',
            ];
        }
        $authorItems = $this->getAuthorItems($businessAccount['account']['username'], $personal_token);
        
        if (!$authorItems['status']) {
            return [
                'status' => false,
                'message' => 'Could not fetch author items',
            ];
        }

        $yourProductIds = collect($authorItems['matches'])->pluck('id')->toArray();
        $response       = $this->getUserPurchaseList($accessToken);

        if (!$response->successful()) {
            return [
                'status' => false,
                'message' => 'Could not fetch user purchases',
            ];
        }

        $purchases = $response->json()['purchases'];
        $verifiedPurchases = [];

        foreach ($purchases as $purchase) {

            if (in_array($purchase['item']['id'], $yourProductIds)) {
                
                $verificationResult = $this->verifyPurchase($purchase['code'], $personal_token);

                if ($verificationResult['status']) {
                    $verifiedPurchases[] = [
                        'code' => $purchase['code'],
                        'product_id' => $purchase['item']['id'],
                        'product_name' => $purchase['item']['name'],
                    ];
                }
            }
        }

        return [
            'status' => true,
            'verified_purchases' => $verifiedPurchases,
        ];
    }
}