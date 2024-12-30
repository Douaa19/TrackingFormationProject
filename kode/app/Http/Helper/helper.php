<?php

use App\Enums\BadgeClass;
use App\Enums\PriorityStatus;
use App\Enums\StatusEnum;
use App\Enums\TicketStatus;
use App\Models\Category;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Settings;
use App\Models\Translation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

    if (!function_exists('storeImage')) {
        function storeImage($file, $location, $size = null, $removeFile = null,$name = null): string
        {

        
            $name =  $name ? $name.'.' . $file->getClientOriginalExtension():  uniqid() . time() . '.' . $file->getClientOriginalExtension();

            $imagePath = $location . '/' .$name ;

            if(site_settings('storage') == 's3'){
                 set_aws_config();
                 if ($removeFile) {
                    \Storage::disk('s3')->delete($location . '/' . $removeFile);
                 }

                 $path = \Storage::disk('s3')->putFileAs(
                     $location ,
                     $file,
                     $name
                );
            }
            else{
                if (!file_exists($location)) {
                    mkdir($location, 0755, true);
                }

                if ($removeFile && file_exists($location . '/' . $removeFile) && is_file($location . '/' . $removeFile)) {
                    @unlink($location . '/' . $removeFile);
                }

                $image = Image::make(file_get_contents($file));

                if (isset($size)) {
                    list($width, $height) = explode('x', strtolower($size));
                    $image->resize($width, $height);
                }
                $image->save($imagePath);
            }
            return $name;

        }
    }

    //set aws configarations

    if (!function_exists('set_aws_config')) {

        function set_aws_config(){

            $aws_config = json_decode(site_settings('aws_s3'),true);
            config(
                [
                    'filesystems.disks.s3.key'    => $aws_config['s3_key'],
                    'filesystems.disks.s3.secret' => $aws_config['s3_secret'],
                    'filesystems.disks.s3.region' => $aws_config['s3_region'],
                    'filesystems.disks.s3.bucket' => $aws_config['s3_bucket'],
                    'filesystems.disks.s3.use_path_style_endpoint' => false,
                ]
            );
        }

    }



    if (!function_exists('getFilePaths')) {
        function getFilePaths(): array
        {
            return [
                'profile' => [
                    'admin' => [
                        'path' => 'assets/images/backend/profile',
                        'size' => '150x150',
                    ],
                    'user' => [
                        'path' => 'assets/images/frontend/profile',
                        'size' => '150x150',
                    ],
                ],


                'envato_item_logo' => [
                    'path' => 'assets/images/backend/envato_item_logo',
                ],

                'site_logo' => [
                    'path' => 'assets/images/backend/site_logo',
                ],

                'logo_lg' => [
                    'path' => 'assets/images/backend/site_logo',
                ],

                'logo_sm' => [
                    'path' => 'assets/images/backend/site_logo',
                ],

                'frontend' => [
                    'path' => 'assets/images/frontend/content_image',
                ],

                'ticket' => [
                    'path' => 'assets/files/global/ticket',
                ],

                'text_editor' => [
                    'path' => 'assets/files/global/text_editor',
                ],

                'csv_file' => [
                    'path' => 'assets/files/global/csv',
                ],

                'favicon' => [

                    'path' => 'assets/images/global/favicon',
                    'size' => '128x128',
                ],

                'category' => [

                    'path' => 'assets/images/global/category',
                    'size' => '96x96',
                ],

                'department' => [

                    'path' => 'assets/images/global/department',
                    'size' => '200x200',
                ],
            ];
        }
    }


        //remove a file
	if (!function_exists('download_file')){

        function download_file($location, $file)
		{
            $filePath = $location . '/' . $file;
            $url = null;

            try {
                if(site_settings('storage') == 's3'){
                    $headers = [
                        'Content-Disposition' => 'attachment; filename="'. $file .'"',
                    ];
                    $url =  Response::make(\Storage::disk('s3')->get($filePath),200, $headers);
                }
                else{
                    $headers = [
                        'Content-Type' => File::mimeType($filePath),
                    ];
                    $url =  Response::download( $filePath,$file, $headers);
                }
            } catch (\Throwable $th) {

            }

            return $url;;
        }
    }


    //remove a file
	if (!function_exists('remove_file')){
		function remove_file($location, $removefile )
		{

            $response = false;
            try {
                if(site_settings('storage') == 's3'){
                    set_aws_config();
                    \Storage::disk('s3')->delete($location . '/' . $removefile);
                    $response = true;
                }
                else{

                    if(file_exists($location) && file_exists($location.'/'.$removefile) && is_file($location.'/'.$removefile)){
                        @unlink($location.'/'.$removefile);
                        $response = true;
                    }
                }
            } catch (\Throwable $th) {

            }
            return $response;

		}
	}



    if (!function_exists('check_file')) {
        function check_file(string $url) :bool
        {
            $headers = get_headers($url);
            return (bool) preg_match('/\bContent-Type:\s+(?:image|audio|video)/i', implode("\n", $headers));
        }
    }


    if (!function_exists('upload_new_file')){

		function upload_new_file($file, $location, $old = null){

			$name = uniqid() . time() . '.' . $file->getClientOriginalExtension();
            if(site_settings('storage') == 's3'){
                set_aws_config();
                $path = \Storage::disk('s3')->putFileAs(
                    $location ,
                    $file,
                    $name
                  );
            }
            else{
                if(!file_exists($location)){
                    mkdir($location, 0755, true);
                }
               if(!$location) throw new Exception('File could not been created.');
               if ($old) {
                   if(file_exists($location.'/'.$old) && is_file($location.'/'.$old)){
                       @unlink($old.'/'.$old);
                   }
               }
               $file->move($location,$name );
            }

			return $name;
	    }
    }



    /**
     * check agent permissions
     */
    if (!function_exists('check_agent')) {
        function check_agent(string $permission) :bool
        {
            if(auth_user('admin')->agent == (StatusEnum::true)->status() ){

                if((auth_user('admin')->super_agent == (StatusEnum::true)->status())) return true;

                $permissions =  json_decode(auth_user('admin')->permissions,true) 
                                    ?json_decode(auth_user('admin')->permissions,true) 
                                    :[] ;

                if(in_array($permission,$permissions)) return true;

                return false;
            }
            return true;
        }
    }

    if (!function_exists('calculate_distance')){
        function calculate_distance($lat1, $lon1, $lat2, $lon2)
        {
            $radius = 6371;
            $degLat = deg2rad($lat2 - $lat1);
            $degLon = deg2rad($lon2 - $lon1);
            $tmp = sin($degLat / 2) * sin($degLat / 2) +
                cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
                sin($degLon / 2) * sin($degLon / 2);
            $tmp2 = 2 * atan2(sqrt($tmp), sqrt(1 - $tmp));
            $distance = $radius * $tmp2;
            return $distance;
        }
    }


    // agent permissons
    if (!function_exists('agent_permissions'))  {

        function agent_permissions() :array{

            $permissions  = [
                'view_dashboard',
                'manage_category',
                'manage_users',
                'mail_configuration',
                'sms_configuration',
                'system_configuration',
                'manage_language',
                'manage_tickets',
                'update_tickets',
                'assign_tickets',
                'delete_tickets',
                'chat_module',
                'manage_faqs',
                'manage_article',
                'manage_frontends',
                'manage_pages',
                'manage_contact',
                'manage_priorites',
                'manage_ticket_status',
                'manage_product',
            ];
            
            return $permissions;
        }

    }

    if (!function_exists('get_address_by_ip')) {
        function get_address_by_ip($client_ip)
        {
            $url = "http://ip-api.com/json/$client_ip";
            $address_data = json_decode(file_get_contents($url),true);
            return $address_data;
        }
    }


    if (!function_exists('getImageUrl')) {
        /**
         * @param $image
         * @param $size
         * @return string
         */
        function getImageUrl($image, $size = null)
        {


            $image_url = asset('assets/images/default.jpg');
            if($size){
                $image_url =  route('default.image', $size);
            }
            try {
                if(site_settings('storage') =='s3'){
                    set_aws_config();
                    $file = \Storage::disk('s3')->url($image);
                    if(check_file( $file)){
                        $image_url  = $file;
                    }
                }
                else{
                    if (file_exists($image) && is_file($image)) {
                        $image_url =  asset($image);
                    }
                }

            } catch (\Throwable $th) {

            }

            return  $image_url;
        }
    }

    if (!function_exists('isImageUrl')) {

        /**
         * Summary of isImageUrl
         * @param mixed $url
         * @return bool
         */
        function isImageUrl($url){
                $headers = @get_headers($url, 1);
            
                if ($headers && strpos($headers[0], '200')) {
                    $contentType = isset($headers['Content-Type']) ? $headers['Content-Type'] : null;
                    return strpos($contentType, 'image/') === 0;
                }

                return false;
        }

    }



    if (!function_exists('paginateNumber')) {
        function paginateNumber(){
          return site_settings('pagination_number');
        }
    }

    if (!function_exists('get_real_ip')){
        function get_real_ip() :string{
  
           $ip = $_SERVER["REMOTE_ADDR"];
  
           if (filter_var(@$_SERVER['HTTP_FORWARDED'], FILTER_VALIDATE_IP)) {
               $ip = $_SERVER['HTTP_FORWARDED'];
           }
           if (filter_var(@$_SERVER['HTTP_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
               $ip = $_SERVER['HTTP_FORWARDED_FOR'];
           }
           if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
               $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
           }
           if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
               $ip = $_SERVER['HTTP_CLIENT_IP'];
           }
           if (filter_var(@$_SERVER['HTTP_X_REAL_IP'], FILTER_VALIDATE_IP)) {
               $ip = $_SERVER['HTTP_X_REAL_IP'];
           }
           if (filter_var(@$_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP)) {
               $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
           }
           if ($ip == '::1') {
               $ip = '127.0.0.1';
           }
       
           return $ip;
        }
    }


	if (!function_exists('get_ip_info')) {
		function get_ip_info(): array
		{
            try {
                $ip = get_real_ip();

	
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://www.geoplugin.net/xml.gp?ip=".$ip);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                $response = curl_exec($ch);
                curl_close($ch);
        
                if ($response === false) {
                    $xml = false;
                } else {
                    $xml = simplexml_load_string($response);
                }
    
        
                $country  = $xml ? (string)$xml->geoplugin_countryName : "";
                $countryCode  = $xml ? (string)$xml->geoplugin_countryCode : "";
                $timeZone  = $xml ? (string)$xml->geoplugin_timezone : "";
                $city     = $xml ? (string)$xml->geoplugin_city : "";
                $long     = $xml ? (string)$xml->geoplugin_longitude : "";
                $lat      = $xml ? (string)$xml->geoplugin_latitude : "";
    
                $user_agent = $_SERVER['HTTP_USER_AGENT'];
       
                $os_platform = "Unknown OS Platform";
                $os_array = array(
                    '/windows nt 10/i'     => 'Windows 10',
                    '/windows nt 6.3/i'    => 'Windows 8.1',
                    '/windows nt 6.2/i'    => 'Windows 8',
                    '/windows nt 6.1/i'    => 'Windows 7',
                    '/windows nt 6.0/i'    => 'Windows Vista',
                    '/windows nt 5.2/i'    => 'Windows Server 2003/XP x64',
                    '/windows nt 5.1/i'    => 'Windows XP',
                    '/windows xp/i'        => 'Windows XP',
                    '/windows nt 5.0/i'    => 'Windows 2000',
                    '/windows me/i'        => 'Windows ME',
                    '/win98/i'             => 'Windows 98',
                    '/win95/i'             => 'Windows 95',
                    '/win16/i'             => 'Windows 3.11',
                    '/macintosh|mac os x/i'=> 'Mac OS X',
                    '/mac_powerpc/i'       => 'Mac OS 9',
                    '/linux/i'             => 'Linux',
                    '/ubuntu/i'            => 'Ubuntu',
                    '/iphone/i'            => 'iPhone',
                    '/ipod/i'              => 'iPod',
                    '/ipad/i'              => 'iPad',
                    '/android/i'           => 'Android',
                    '/blackberry/i'        => 'BlackBerry',
                    '/webos/i'             => 'Mobile'
                );
        
                foreach ($os_array as $regex => $value) {
                    if (preg_match($regex, $user_agent)) {
                        $os_platform = $value;
                    }
                }
        
                $browser = "Unknown Browser";
                $browser_array = array(
                    '/msie/i'      => 'Internet Explorer',
                    '/firefox/i'   => 'Firefox',
                    '/safari/i'    => 'Safari',
                    '/chrome/i'    => 'Chrome',
                    '/edge/i'      => 'Edge',
                    '/opera/i'     => 'Opera',
                    '/netscape/i'  => 'Netscape',
                    '/maxthon/i'   => 'Maxthon',
                    '/konqueror/i' => 'Konqueror',
                    '/mobile/i'    => 'Handheld Browser'
                );
        
                foreach ($browser_array as $regex => $value) {
                    if (preg_match($regex, $user_agent)) {
                        $browser = $value;
                    }
                }
        
    
                
    
                $data = [
                    'country'     => $country,
                    'countryCode' => $countryCode,
                    'city'        => $city,
                    'lon'         => $long,
                    'lat'         => $lat,
                    'os_platform' => $os_platform,
                    'browser'     => $browser,
                    'ip'          => $ip,
                    'timezone'    => $timeZone,
                    'time'        => date('d-m-Y h:i:s A')
                ];
    
                return $data;
            } catch (\Exception $ex) {
                return [
                    'error' => $ex->getMessage()
                ];
            }
		
		}
	}

  

    
    if (!function_exists('check_for_update')) {
        function check_for_update(){

            $newVersion     = @(double) Arr::get(config("requirements")['core'],'appVersion',1.0);
            $currentVersion = @(double) site_settings(key : "app_version",default :1.0);
            return ($newVersion  > $currentVersion) ? true : false;
    
        }
    }


    if (!function_exists('response_status')){
        function response_status(string $message = 'Sucessfully Completed' ,string $key = 'success') :array{
           return [
                 $key =>  translate($message)
           ];
        }
     }
  


    
   if (!function_exists('k2t')){
       function k2t(string $text) :string{
           return ucfirst(preg_replace("/[^A-Za-z0-9 ]/", ' ', $text));
        }
    }
    
    if (!function_exists('t2k')){
        function t2k(string $text ,?string $replace = "_") :string {
           return strtolower(strip_tags(str_replace(' ', $replace, $text)));
        }
    }


    if (!function_exists('site_settings')) {
        function site_settings($key = null ,$pluck = 'value' ,$default = null){

            $settings = Cache::remember('site_settings',24 * 60, function () use($pluck)  {
                return Settings::pluck($pluck ,'key')->toArray();
            });

            if($key){
                if(array_key_exists($key,$settings )){
                    $default   =  $settings[$key];
                }
            }
            return $default;
        }
    }

    if (!function_exists('plugin_settings')) {

        function plugin_settings($key = null ,$pluck = 'value'){
            $settings = Cache::remember('site_settings',24 * 60, function () use($pluck)  {
                return Settings::pluck($pluck ,'key')->toArray();
            });
            if($key){
                if(array_key_exists($key,$settings )){
                    return $settings[$key];
                }
            }
            return $settings;
        }
    }



    //limit words
    if (!function_exists('limit_words')) {
        function limit_words($text, $limit = 25) {
            

            return \Illuminate\Support\Str::limit($text, $limit, $end='...');
        }
    }


    if (!function_exists('getTimeDifference')) {
        /**
         * @param $date
         * @return string
         */
        function getTimeDifference($date): string
        {
            return Carbon::parse($date)->diffForHumans();
        }
    }


    if (!function_exists('getDateTime')) {
        /**
         * @param $date
         * @param string $format
         * @return string
         */
        function getDateTime($date, string $format = 'Y-m-d h:i A'): string
        {
            return Carbon::parse($date)->translatedFormat($format);
        }
    }

    if (!function_exists('generateSlug')) {
        /**
         * @param $name
         * @return string
         */
        function generateSlug($text): string
        {
            return preg_replace('/\s+/u', '-', trim(strtolower($text)));
        }
    }



    if (!function_exists('generateRandomNumber')) {
        /**
         * @return int
         */
        function generateRandomNumber(): int
        {
            return mt_rand(1, 10000000);
        }

    }


    if (!function_exists('sortText')) {
        /**
         * @param $text
         * @return string
         */
        function sortText($text): string
        {
            return ucfirst(preg_replace("/[^A-Za-z0-9 ]/", ' ', $text));
        }

    }

    if (!function_exists('sortByMonth')) {
        function sortByMonth($data ,$empty_check = true){
            
            $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
            $sortedArray = [];
            foreach($months as $month){
                if(!$empty_check){
                    $sortedArray[$month] = @$data[$month] ?? 0;
                }elseif(isset($data[$month])){
                  $sortedArray[$month] = $data[$month];
                  
                }
 
            }
            return $sortedArray;
        }
    }


    if (!function_exists('ticket_settings')) {
        /**
         * @param $text
         * @return string
         */
        function ticket_settings() :array
        {

            $ticket_settings = [
                [
                    'labels' => 'Name',
                    'name' => 'name',
                    'placeholder' => 'Name',
                    'type' => 'text',
                    'required' => '1',
                    'default' => '1',
                    'multiple' => '0'
                ],

                [
                    'labels' => 'Email',
                    'name' => 'email',
                    'placeholder' => 'Email',
                    'type' => 'email',
                    'required' => '1',
                    'default' => '1',
                    'multiple' => '0'
                ],
                [

                    'labels' => 'Category',
                    'name' => 'category',
                    'placeholder' => 'Category',
                    'type' => 'select',
                    'required' => '1',
                    'default' => '1',
                    'multiple' => '0'
                ],
                [
                    'labels' => 'Subject',
                    'name' => 'subject',
                    'placeholder' => 'Subject',
                    'type' => 'text',
                    'required' => '1',
                    'default' => '1',
                    'multiple' => '0'
                ],
                [
                    'labels' => 'Description',
                    'name' => 'description',
                    'placeholder' => 'Description',
                    'type' => 'textarea',
                    'required' => '1',
                    'default' => '1',
                    'multiple' => '0'
                ],
                [
                    'labels' => 'Attachments',
                    'name' => 'attachment',
                    'placeholder' => 'You Can Upload Multiple File Here',
                    'type' => 'file',
                    'required' => '1',
                    'default' => '1',
                    'multiple' => '1'
                ],
            ];
           return ($ticket_settings);

        }

    }


    if (!function_exists('limitText')) {

        /**
         * @param $text
         * @param $length
         * @return string
         */
        function limitText($text, $length): string
        {
            return Str::limit($text, $length);
        }

    }


    // translate static text
	if (!function_exists('translate')){

        /**
         * @param $keyWord
         * @param $langCode
         * @return mixed
         */
		function translate($keyWord,$keys = [] , $lang_code = null)
		{
			try {

                $keyWord = str_replace(
                    array_map(function ($item) {
                        return ":" . $item;
                    }, array_keys($keys)),
                    array_map(function ($item) {
                        return "{{" . $item . "}}";
                    }, array_keys($keys)),
                    $keyWord
                );

				$lang_code = $lang_code ? $lang_code : App::getLocale();
				$lang_key = preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', strtolower($keyWord)));
				$translate_data = Cache::remember('translations-'.$lang_code,now()->addHour(), function () use($lang_code) {
					return Translation::where('code', $lang_code)->pluck('value', 'key')->toArray();
				});
				if (!array_key_exists($lang_key,$translate_data)) {
					$translate_val = str_replace(array("\r", "\n", "\r\n"), "", $keyWord);
					Translation::create([
						'code'  => $lang_code,
						'key'   => $lang_key,
						'value' => $translate_val
					]);
					$keyWord = $translate_val;
					Cache::forget('translations-'.$lang_code);
				}
				else{
					$keyWord = $translate_data[$lang_key];
				}

			} catch (\Throwable $th) {

			}

            $keyWord = str_replace(
                array_map(function ($item) {
                    return "{{" . $item ."}}";
                }, array_keys($keys)),
                array_values($keys),
                $keyWord
            );

			return $keyWord;
		}
     }


     if (!function_exists('update_status')){
		function update_status($id,$modelName,$status,$columName ='status') :array  {
			$response['reload'] = true;
			$response['status'] = false;
			$response['message'] = translate('Status Update Failed');
			try {
				$data =  app(config('constants.options.model_namespace').$modelName)::where('id',$id)
				->latest()
				->first();
				$data->status = $status;
				$data->save();
				$response['status'] = true;
				$response['message'] = translate('Status Updated Successfully');
			} catch (\Throwable $th) {

			}
			return $response;
		}
	}





    //auth user informations
	if (!function_exists('auth_user')){
		function auth_user($guardName = 'admin'){
			return auth()->guard($guardName)->user();
		}
    }

    //get general settings
	if (!function_exists('optimize_clear')){
		function optimize_clear(){
			Artisan::call('optimize:clear');
		}
    }


    //get device name By agent
	if (!function_exists('get_divice_type')){
		function get_divice_type($agent){
			$requestDevice = "Unknown";
            if (strpos($agent, 'Mobile') !== false) {
                $requestDevice = 'Mobile';
            } elseif (strpos($agent, 'Tablet') !== false) {
                $requestDevice = 'Tablet';
            } elseif (strpos($agent, 'TV') !== false) {
                $requestDevice = 'TV';
            } elseif (strpos($agent, 'Windows Phone') !== false) {
                $requestDevice = 'Windows Phone';
            } elseif (strpos($agent, 'Macintosh') !== false) {
                $requestDevice = 'Macintosh';
            } elseif (strpos($agent, 'Windows') !== false) {
                $requestDevice = 'Windows';
            } elseif (strpos($agent, 'Linux') !== false) {
                $requestDevice = 'Linux';
            }
          return $requestDevice;
		}
    }
    //get device name By agent
	if (!function_exists('browser_name')){
		function browser_name($agent){
            $browser = "Unknown";
            if (strpos($agent, 'Firefox') !== false) {
                $browser = 'Mozilla Firefox';
            } elseif (strpos($agent, 'Chrome') !== false) {
                $browser = 'Google Chrome';
            } elseif (strpos($agent, 'Safari') !== false) {
                $browser = 'Apple Safari';
            } elseif (strpos($agent, 'Opera Mini') !== false) {
                $browser = "Opera Mini";
            } elseif (strpos($agent, 'Opera') !== false) {
                $browser = 'Opera';
            } elseif (strpos($agent, 'MSIE') !== false || strpos($agent, 'Trident/') !== false) {
                $browser = 'Microsoft Internet Explorer';
            } elseif (strpos($agent, 'Edge') !== false) {
                $browser = 'Microsoft Edge';
            }

            return $browser;
		}
    }


    //update env method
	if (!function_exists('update_env')){
		function update_env(string $key, string $newValue) :void{
            $path = base_path('.env');
            $envContent = file_get_contents($path);
            if (preg_match('/^' . preg_quote($key, '/') . '=/m', $envContent)) {
                $envContent = preg_replace('/^' . preg_quote($key, '/') . '.*/m', $key . '=' . $newValue, $envContent);
            } else {
                $envContent .= PHP_EOL . $key . '=' . $newValue . PHP_EOL;
            }
            file_put_contents($path, $envContent);
		}
    }

    if (!function_exists('getPaginate')) {
        /**
         * @param int $perPage
         * @return int
         */
        function getPaginate(int $perPage = 20): int
        {
            return $perPage;
        }
    }

    if (!function_exists('replaceInputTitle')) {
        /**
         * @param $text
         * @return string
         */
        function replaceInputTitle($text): string
        {
            return ucwords(preg_replace("/[^A-Za-z0-9 ]/", ' ', $text));
        }
    }


    if (!function_exists('str_unique')) {
        /**
         * @param int $length
         * @return string
         */
        function str_unique(int $length = 16): string
        {
            $side = rand(0,1); 
            $salt = rand(0,9);
            $len = $length - 1;
            $string = Str::random($len <= 0 ? 7 : $len);

            $separatorPos = (int) ceil($length/4);

            $string = $side === 0 ? ($salt . $string) : ($string . $salt);
            $string = substr_replace($string, '-', $separatorPos, 0);

            return substr_replace($string, '-', negative_value($separatorPos), 0);
        }
    }

    if (!function_exists('negative_value')) {
        /**
         * @param int|float $value
         * @param bool $float
         * @return int|float
         */
        function negative_value(int|float $value, bool $float = false): int|float
        {
            if ($float) {
                $value = (float) $value;
            }

            return 0 - abs($value);
        }
    }

    //dif for human by date
	if (!function_exists('diff_for_humans')){
		function diff_for_humans($date)
		{
			return Carbon::parse($date)->diffForHumans();
		}
    }

    // get date by format
	if (!function_exists('get_date_time')){
		function get_date_time($date, $format = 'Y-m-d h:i A')
		{
			return Carbon::parse($date)->translatedFormat($format);
		}
    }


     // get translations
	if (!function_exists('get_translation')){
		function get_translation($data,$lang = null){
            if(!$data){
                return 'N/A';
            }
			$lang = $lang ? $lang : session()->get("locale");
			$lang_data = json_decode($data,true);

			$transate = @$lang_data['en'];
			if(array_key_exists($lang,$lang_data)){
				$transate = $lang_data [$lang];
			}
			return	$transate ? $transate : 'default';
		}
	}

    // get system active languages

    if (!function_exists('system_language')){
        function system_language(){

            return Language::active()->get();
        }
    }

    //get system locale lang
	if (!function_exists('get_system_locale')){
		function get_system_locale(){
          return session()->has('locale') ?  session()->get('locale') : App::getLocale();
		}
	}

    if (!function_exists('agent_categories')){
        // get agent categories
        function agent_categories($categories = []){
            if(!$categories){
                $categories = [];
            }
            return Category::whereIn('id',$categories)->get();
        }
    }

    // get file types
    if (!function_exists('file_types')){
        function file_types(){
            return [    '3dmf',    '3dm',    'avi',    'ai',    'bin',    'bin',    'bmp',    'cab',    'c',    'c++',    'class',    'css',    'csv',    'cdr',    'doc',    'dot',    'docx',    'dwg',    'eps',    'exe',    'gif',    'gz',    'gtar',    'flv',    'fh4',    'fh5',    'fhc',    'help',    'hlp',    'html',    'htm',    'ico',    'imap',    'inf',    'jpe',    'jpeg',    'jpg',    'js',    'java',    'latex',    'log',    'm3u',    'midi',    'mid',    'mov',    'mp3',    'mpeg',    'mpg',    'mp2',    'ogg',    'phtml',    'php',    'pdf',    'pgp',    'png',    'pps',    'ppt',    'ppz',    'pot',    'ps',    'qt',    'qd3d',    'qd3',    'qxd',    'rar',    'ra',    'ram',    'rm',    'rtf',    'spr',    'sprite',    'stream',    'swf',    'svg',    'sgml',    'sgm',    'tar',    'tiff',    'tif',    'tgz',    'tex',    'txt',    'vob',    'wav',    'wrl',    'wrl',    'xla',    'xls',    'xls',    'xlc',    'xml',    'xlsx',    'zip'];
        }
    }



	if (!function_exists('unauthorized_message')){
		function unauthorized_message(string $message='Unauthorized access') :string{
			return translate($message);
		}
    }

    if (!function_exists('set_default_notifications')){
		function set_default_notifications($user) :void{
            $notifications = user_notification();
            Arr::forget($notifications, 'sms');
            foreach($notifications as $key => $notificationValues){
                foreach($notificationValues as $subKey => $value ){
                    $notifications[$key][$subKey] = (StatusEnum::true)->status();
                }
            }
            $user->notification_settings =  json_encode($notifications);
            $user->save();
		}
    }

	if (!function_exists('user_notification')){
		function user_notification() :array{

          $settings = [
             "email"=>[
                "new_chat" => (StatusEnum::false)->status(),
                "ticket_reply" => (StatusEnum::false)->status(),
             ],
             "sms"=>[
                "new_chat" => (StatusEnum::false)->status(),
                "ticket_reply" => (StatusEnum::false)->status(),
             ],
             "browser"=>[
                "new_chat" => (StatusEnum::false)->status(),
                "ticket_reply" => (StatusEnum::false)->status(),
             ],
          ];

          return $settings;

		}
    }


    /**
     * admin notifications settings
     */

    if (!function_exists('admin_notification')){
    function admin_notification() :array{

        $settings = [
            
            "email"=>[
                "new_chat" =>  (StatusEnum::false)->status(),
                "new_ticket" =>  (StatusEnum::false)->status(),
                "agent_ticket_reply" => (StatusEnum::false)->status(),
                "agent_assign_ticket" => (StatusEnum::false)->status(),
                "user_reply_admin" => (StatusEnum::false)->status(),
                "user_reply_agent" => (StatusEnum::false)->status(),
            ],
            "sms"=>[
                "new_chat" =>  (StatusEnum::false)->status(),
                "agent_ticket_reply" => (StatusEnum::false)->status(),
                "new_ticket" => (StatusEnum::false)->status(),
                "agent_assign_ticket" => (StatusEnum::false)->status(),
                "user_reply_agent" => (StatusEnum::false)->status(),
                "user_reply_admin" => (StatusEnum::false)->status(),

            ],
            "browser"=>[
                "new_chat" =>  (StatusEnum::false)->status(),
                "agent_ticket_reply" => (StatusEnum::false)->status(),
                "new_ticket" => (StatusEnum::false)->status(),
                "agent_assign_ticket" => (StatusEnum::false)->status(),
                "user_reply_agent" => (StatusEnum::false)->status(),
                "user_reply_admin" => (StatusEnum::false)->status(),

            ],
            "slack"=>[
                "new_chat" =>  (StatusEnum::false)->status(),
                "agent_ticket_reply" => (StatusEnum::false)->status(),
                "new_ticket" => (StatusEnum::false)->status(),
                "agent_assign_ticket" => (StatusEnum::false)->status(),
                "user_reply_agent" => (StatusEnum::false)->status(),
                "user_reply_admin" => (StatusEnum::false)->status(),
            ],
        ];

        return $settings;

        }

    }

    if (!function_exists('agent_notification')){
    function agent_notification() :array{
        $settings = [

            "email"=>[
                "new_chat" =>  (StatusEnum::false)->status(),
                "new_ticket" =>  (StatusEnum::false)->status(),
                "agent_assign_ticket" => (StatusEnum::false)->status(),
                "admin_assign_ticket" => (StatusEnum::false)->status(),
                "user_reply_agent" => (StatusEnum::false)->status(),
            ],
            "sms"=>[
                "new_chat" =>  (StatusEnum::false)->status(),
                "new_ticket" =>  (StatusEnum::false)->status(),
                "agent_assign_ticket" => (StatusEnum::false)->status(),
                "admin_assign_ticket" => (StatusEnum::false)->status(),
                "user_reply_agent" => (StatusEnum::false)->status(),
            ],

            "browser"=>[
                "new_chat" =>  (StatusEnum::false)->status(),
                "new_ticket" =>  (StatusEnum::false)->status(),
                "agent_assign_ticket" => (StatusEnum::false)->status(),
                "admin_assign_ticket" => (StatusEnum::false)->status(),
                "user_reply_agent" => (StatusEnum::false)->status(),
            ],

        ];

        return $settings;

        }

    }

	if (!function_exists('ticket_file_validation')){
		function ticket_file_validation($files) {
            $message = null;
            $extensions = json_decode(site_settings('mime_types'),true);

            if(is_array($files)){

                if(count($files) > (int) site_settings('max_file_upload')){
                    $message = " ".translate("You Can Not Upload More Than ").site_settings('max_file_upload').translate(' File At a Time');
                }
                else{
                    foreach($files as $file){
                        $fileSizeInBytes = $file->getSize();
                        if( round($fileSizeInBytes / 1024) >  (int) site_settings('max_file_size')){
                            $message = translate('File Size Must be Under '). site_settings('max_file_size'). translate('KB');
                            break;
                        }
                        elseif(!in_array($file->getClientOriginalExtension(), $extensions)){
                            $message = translate('File Must be '.implode(", ", $extensions).' Format');
                            break;
                        }
                    }
                }

            }
            else{
                $fileSizeInBytes = $files->getSize();
                if( round($fileSizeInBytes / 1024) >  (int) site_settings('max_file_size')){
                    $message = translate('File Size Must be Under '). site_settings('max_file_size'). translate('KB');
                }
                elseif(!in_array($files->getClientOriginalExtension(), $extensions)){
                    $message = translate('File Must be '.implode(", ", $extensions).' Format');

                }
            }
           return $message;


		}
    }

	if (!function_exists('generateTicketNumber')){
        function generateTicketNumber()
        {
            $randomNumber = uniqid(mt_rand(), true); 
            $processId = getmypid(); 
            $combined = $randomNumber . $processId;
            $hashed = strtoupper(hash('sha256', $combined)); 
    
            $ticketNumber = substr($hashed, 0, 6);
            return $ticketNumber;
        }
    }

    if (!function_exists('build_dom_document')){
        /**
         * Summary of buildDomDocument
         * @param mixed $text
         */
        function build_dom_document($text,$name ='text_area') :array
        {
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML('<meta charset=utf-8">' . $text);
            libxml_use_internal_errors(false);
            $imageFile = $dom->getElementsByTagName('img');
            if ($imageFile) {
                $files = [];
                foreach($imageFile as $item => $image){
                    $data = $image->getAttribute('src');
                    $check_b64_data = preg_match("/data:([a-zA-Z0-9]+\/[a-zA-Z0-9-.+]+).base64,.*/", $data);
                    if ($check_b64_data) {
                        list($type, $data) = explode(';', $data);
                        list(, $data)      = explode(',', $data);
                        $imgeData = base64_decode($data);
                        $image_name= $name.time().$item.'.png';
                        $save_path  = getFilePaths()['text_editor']['path'];

                        try {
                            if(!file_exists($save_path)){
                                mkdir($save_path, 0755, true);
                            }
                            Image::make($imgeData)->save($save_path.'/'.$image_name);
                            $getpath = asset(getFilePaths()['text_editor']['path'].'/'.$image_name);

                            $image->removeAttribute('src');
                            $image->setAttribute('src', $getpath);
                            array_push($files,$image_name);
                        } catch (Exception $e) {

                        }
                    }
                }
            }
            $html = $dom->saveHTML();
            $html = html_entity_decode($html, ENT_COMPAT, 'UTF-8');
            return [
                'html'  => $html,
                'files' => $files,
            ];
        }
    }



     /**
      * ticket  status badge
      */

     if (!function_exists('ticket_status')){
        function ticket_status(?string $status  ,?string $code  ,int|string $fs = 10) :string {

            $code   = $code?? "#26b56f";

            $class = "i-badge";
            if(request()->routeIs("admin.*") || request()->routeIs("user.*")){
                 $class = "badge rounded-pill";
            }

            return "<span class=\"  fs-$fs  $class \" style=\"background: $code\" >
                $status
            </span>";

        }
    }


    /**
     * get status badge
     */

    if (!function_exists('get_bg_status')){
        function get_bg_status(string $status , bool $priority = false , bool $bg = false ) :string {

            $class = 'info';
            $statusArr = combine_array(BadgeClass::values(), $priority ? PriorityStatus::values() : TicketStatus::values());

            if(isset($statusArr[$status])){
                $class = $statusArr[$status];
            }

            if(request()->routeIs("admin.*") || request()->routeIs("user.*")){
                 $class = $bg ? "bg-".$class : "badge-soft-".$class;
            }

            $fs = $bg ? "fs-12" :"fs-10";

            $status = ucfirst(strtolower(array_flip($priority ? PriorityStatus::toArray() : TicketStatus::toArray())[$status]));
            

            $badgeClass =  "i-badge  ".$class;

            if(request()->routeIs("admin.*") || request()->routeIs("user.*")){

                $badgeClass = $fs." badge rounded-pill ".$class;
            }

            return "<span class=\"$badgeClass\">
                $status
            </span>";

        }

    }



     /**
     * get status badge
     */

    if (!function_exists('priority_status')){
        function priority_status(?string $status  ,?string $code  ,int|string $fs = 10) :string {

            $status = $status?? "Low";
            $code   = $code?? "#26b56f";

            $class = "i-badge";
            if(request()->routeIs("admin.*") || request()->routeIs("user.*")){
                 $class = "badge rounded-pill";
            }

            return "<span class=\"  fs-$fs  $class \" style=\"background: $code\" >
                $status
            </span>";

        }

    }


     /**
      * combine two array
      */

    if (!function_exists('combine_array')){

        function combine_array($arr1 , $arr2){
            $newArr = [];
            foreach($arr2 as $key=>$val){
                if(isset($arr1[$key])){
                    $newArr [$val]  = $arr1[$key];
                }

            }
            return  $newArr;
        }
    }


     


    if (!function_exists('frontend_section_data')) {
        function frontend_section_data($data,$type,$key ='value',$content_type = 'static_element')
        {
		   $val = '';
           $data = json_decode($data,true);
		   if(isset($data[$content_type ][$type])){
			 $val = $data[$content_type ][$type][$key];
		   }
		   return $val;
        }
    }

     //frornternd section
	if (!function_exists('frontend_section')){
		function frontend_section($slug = null) :mixed
		{
			if($slug){
				$frontends = Frontend::where('slug',$slug)->first();;
			}
			else{
				$frontends =  Frontend::get();
			}

            return $frontends;
		}
	}

    //make slug
    if (!function_exists('make_slug')){
        function make_slug($text) :string
		{
			return strtolower(str_replace(" ","-",$text));
		}
    }



    if (!function_exists('num_short')){
		function num_short(mixed  $number) :mixed
		{
         if ($number >= 1000000) {
            $number =  number_format($number / 1000000, 1) . 'm';
         } elseif ($number >= 1000) {
            $number =  number_format($number / 1000, $number % 1000 === 0 ? 0 : 1) . 'k';
         } else {
            $number =  number_format($number);
         }

         return  $number. PHP_EOL;
		}
   }



   if (!function_exists('pastDate')){
     function pastDate($day){

        switch ($day) {
        case "yesterday":
            $number  = 1;
            break;
        case "last_7_days":
            $number  = 7;
            break;
        case "last_30_days":
            $number  = 30;
            break;

        default:
            $number = 0;
        }
        return $number;
     }
   }


   if (!function_exists('validateModelStatus')){
    function validateModelStatus(Request $request , array $modelInfo){

        $rules = [
            'data.id'=> ['required','exists:'.$modelInfo['table'].",".$modelInfo['key']],
            'data.status'=> ['required',Rule::in($modelInfo['values'])]
        ];

        $request->validate($rules);

     }
   }



   if (!function_exists('hexa_to_rgba')){
    function hexa_to_rgba(string $code):string
    {
        list($r, $g, $b) = sscanf($code, "#%02x%02x%02x");
        return  "$r,$g,$b";
    }
  }



   if (!function_exists('convertHoursToDays')) {
    function convertHoursToDays(float $hours): string
    {
        if ($hours >= 1) {
            $days = floor($hours / 24);
            $remainingHours = $hours - ($days * 24);

            $hoursPart = floor($remainingHours);
            $minutesPart = round(($remainingHours - $hoursPart) * 60);

            $result = [];

            if ($days > 0) {
                $result[] = "$days days";
            }

            if ($hoursPart > 0) {
                $result[] = "$hoursPart hours";
            }

            if ($minutesPart > 0) {
                $result[] = "$minutesPart minutes";
            }

            return implode(' ', $result);
        } elseif ($hours >= 1 / 60) {
            $minutes = round($hours * 60);
            return "$minutes minutes";
        } 

        return "less than a minute";
    }
}



if (!function_exists('ticket_response_format')){
    function ticket_response_format(mixed $priorityObj , mixed $createdAt ,  mixed $responseTime ,bool $resolve = false) :array {



        $timeDifference      = ($resolve ? "Resolved": "Reseponse")." In Time";
        $status              = true;
        $responsedAt         =  Carbon::parse($responseTime);   // response or resolve time
        $createdAt           =  Carbon::parse($createdAt);      // ticket creation time
        $responseRequiredAt  =  null;

        $formats = [
            'Hour'    => 'addHours',
            'Week'    => 'addWeeks',
            'Minute'  => 'addMinutes',
            'Day'     => 'addDays',
        ];

        $format = $priorityObj->format;

        if (array_key_exists($format, $formats)) {
            $responseRequiredAt = $createdAt->{$formats[$format]}((int)$priorityObj->in);
        }


        if ($responsedAt  && $responseRequiredAt) {

            if($responsedAt > $responseRequiredAt){
                $status                   = false;
                $timeDifference           =  $responsedAt->diffForHumans($responseRequiredAt);;
            }

        }

        return [
            "status"   => $status,
            "message"  => $timeDifference,
        ];

    }
  }

  if (!function_exists('is_demo')){
     function is_demo() :bool {
        return strtolower(env('APP_MODE')) == 'demo' ? true : false;
     }
  }


  if (!function_exists('generateOTP')){
    function generateOTP(int $length = 6) {

        if ($length == 0) return random_int(10000,200000);
        $min = pow(10, $length - 1);
        $max = (int) ($min - 1) . '9';
        return random_int($min, $max);
    }
}


    if (!function_exists('getConditionOperator')){
        function getConditionOperator(string  $type, array $trigger) :Collection  {

            $conditions = array_values(Arr::get($trigger,'conditions',[]));

            $combinedConditions = array_reduce($conditions, function ($carry, $item) {
                return array_merge($carry, ($item));
            }, []);
            $operatorKeys = Arr::get(Arr::get($combinedConditions ,$type ,[] ),'operators',[]);


            $operators    = collect(array_values(Arr::get($trigger,'operators',[])));

            $operators    = collect($operators->only($operatorKeys)->all());

            return $operators;
    
        }
    }


    if (!function_exists('getConditionInputs')){
        function getConditionInputs(string  $key, array $trigger) :array  {

            $conditions = array_values(Arr::get($trigger,'conditions',[]));

            $combinedConditions = array_reduce($conditions, function ($carry, $item) {
                return array_merge($carry, ($item));
            }, []);


            return Arr::get($combinedConditions  , $key);

        }
    }


    if (!function_exists('getTriggerAction')){
        function getTriggerAction(string  $key, array $trigger) : ? array  {

            $actions = (Arr::get($trigger,'actions',[]));


            $action  =  collect( $actions)->where('name', $key)->first();


            return Arr::get( $action , 'inputs', null);



        }
    }


    if (!function_exists('get_ai_option')){
		function get_ai_option() :array{


			return [
				
				'improve_it' => [
					'prompt' => "Improve the above message writing"
				],
				'Grammer Correction' => [
					'prompt' => "Correct any grammatical mistake in the message"
				],
				'make_it_more_detailed' => [

					'prompt' => "Make this message More Detailed"
				],
				'simplyfy_it' => [
					'prompt' => "Simplyfy this message"
				],
				'make_it_informative' => [
					'prompt' => "Make the message more informative"
				],
				'fix_any_mistake' => [
					'prompt' => "Fix if there is any mistake in the message"
				],
				'sound_fluent' => [
					'prompt' => "Make this message as it sound more fluent"
				],
				'make_it_objective' => [
					'prompt' => "Make  this message more objective"
				],
			];

		}
          
    }

	if (!function_exists('get_ai_tone')){
		function get_ai_tone() :array{


			return [

				'engaging' => [
					'display_name' => "Make It Engaging",
					'prompt'       => "Make the message content tone more engaging",

				],
				'sound_formal' => [
					'display_name' => "Sound Formal",
					'prompt'       => "Make the message content tone more formal",
				],
				'sound_casual' => [
					'display_name' => "Sound Casual",
					'prompt'       => "Make the message  content tone  sound more casual",
				],
				'friendly' => [
					'display_name' => "Make It Friendly",
					'prompt'       => "Make the message content tone more user friendly",
				],

				'exciting' => [
					'display_name' => "Make It Exciting",
					'prompt'       => "Make the message content tone more exciting",
				],

				'confident' => [
					'display_name' => "Make It Confident",
					'prompt'       => "Make the message content tone more Confident",
				],

				'assertive' => [
					'display_name' => "Make It Assertive",
					'prompt'       => "Make the message content tone more assertive",
				]
			
			];

		}
          
    }










    if (!function_exists('get_default_image')){
		function get_default_image() :string{
            return asset('assets/images/default.jpg');
        }
    }


    if (!function_exists('removeSpecialCharacters')){

        /**
         * Remove all special characters except space 
         *
         * @param string|null $message
         * @return string | null
         */
        function removeSpecialCharacters(? string $message = null)  : string | null {

            return preg_replace('/[^a-zA-Z0-9\s]/', '', $message);

        }
    }




    if (!function_exists('generateOperatingTimes')) {
        function generateOperatingTimes($intervalMinutes = 15)
        {
            $times = [];
            $startTime = Carbon::createFromTime(0, 0, 0); 
            $endTime = $startTime->copy()->addDay();
    
            while ($startTime->lessThan($endTime)) {
                $times[] = $startTime->format('g:i A');
                $startTime->addMinutes($intervalMinutes);
            }
    
            return $times;
        }
    }





    if (!function_exists('getInputTypes')) {
        function getInputTypes(): array{
 
            return ['number', 'textarea', 'date', 'email', 'text', 'select', 'radio', 'checkbox'];
        }
    }





