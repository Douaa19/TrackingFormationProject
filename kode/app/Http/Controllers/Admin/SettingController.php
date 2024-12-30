<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Schema;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Services\Admin\DepartmentService;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Rules\General\FileExtentionCheckRule;
use App\Traits\EnvatoManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class SettingController extends Controller
{
    use EnvatoManager;

    /**
     * get all system settings
     * @return View
     */
    public function index() :View
    {
        $title     = "General Setting";
        $timeZones = timezone_identifiers_list();
        $countries = json_decode(file_get_contents(resource_path('views/partials/country_file.json')));
        return view('admin.setting.index', compact('title', 'timeZones','countries'));
    }



    /** 
     * @return View
     */
    public function envatoConfiguration() :View
    {
        if(auth_user()->agent != StatusEnum::false->status()) abort(403,unauthorized_message());
        $title = "Envato Configuration";
        return view('admin.setting.envato.configuration', compact('title'));
    }

    public function envatoItemSync(Request $request)
    {
        if (auth_user()->agent != StatusEnum::false->status())   abort(403, unauthorized_message());
        $validator = \Validator::make($request->all(), [
            'personal_token' => 'required|string',
        ]);

        if ($validator->fails()) return $this->jsonResponse('danger', translate('Personal token is required'), 400);


        try {
            $personalToken = $request->input('personal_token');

            $username = $this->fetchEnvatoUsername($personalToken);
            if (isset($username['status'])) {
                return $this->jsonResponse($username['status'], $username['message'], 400);
            }

            $payload = $this->getAuthorItems($username, $personalToken);



            if (isset($payload['matches'])) {
                $departmentService = new DepartmentService;
                $flag = $this->processItems($payload['matches'], $departmentService);

                if ($flag) {
                    return $this->jsonResponse('success', translate('Items synced successfully'));
                } else {
                    return $this->jsonResponse('danger', translate('Could not sync at the moment, please try again later'));
                }
            } else {
                return $this->jsonResponse('danger', translate('No items found to sync or username not found'));
            }
        } catch (\Exception $e) {

            return $this->jsonResponse('danger', translate('Something went wrong'), 500);
        }
    }

    private function fetchEnvatoUsername(string $personalToken)
    {
        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->request('GET', 'https://api.envato.com/v1/market/private/user/username.json', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $personalToken,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['username'])) {
                return $data['username'];
            } else {
                return [
                    'status' => 'danger',
                    'message' => translate('Username not found in response')
                ];
            }


         
        } catch (\GuzzleHttp\Exception\ClientException $e) {

            $errorResponse = $e->getResponse();
            $errorMessage = 'Failed to fetch Envato username';

            if ($errorResponse) {
                $errorBody = json_decode($errorResponse->getBody()->getContents(), true);
                if (isset($errorBody['error'])) $errorMessage = $errorBody['error'];
            }

            return [
                'status' => 'danger',
                'message' => $errorMessage
            ];
        } catch (\Exception $e) {

            return [
                'status' => 'danger',
                'message' => 'An unexpected error occurred: ' . $e->getMessage()
            ];
        }
    }

    private function processItems(array $items, DepartmentService $departmentService): bool
    {
        $flag = false;
        foreach ($items as $item) {
            $flag = $departmentService->saveDepartment($item);
        }
        return $flag;
    }

    private function jsonResponse(string $status, string $message, int $statusCode = 200)
    {
        return response()->json([
            'status'  => $status,
            'message' => $message,
        ], $statusCode);
    }

    /**
     * get ai settings
     * @return View
     */
    public function aiSettings() :View
    {
        if(auth_user()->agent != StatusEnum::false->status()){
            abort(403,unauthorized_message());
        }
        $title         = "Ai Configuration";
        return view('admin.setting.ai_config', compact('title'));
    }


    /**
     * view system config
     * @return View
     */
    public function systemConfiguration() :View
    {
        $title = "Sytem Configuration";
        return view('admin.setting.system_configuration', compact('title'));
    }



    /**
     * view system config
     * @return View
     */
    public function ticketConfiguration() :View
    {
        $title = "Ticket Configuration";

        $timeLocations = timezone_identifiers_list();
        $countries     = json_decode(file_get_contents(resource_path('views/partials/country_file.json')));
        return view('admin.setting.ticket_configuration', compact('title', 'timeLocations','countries'));
    }




    /**
     * update pluging settings
     * @return string
     */
    public function pluginSetting(Request $request) :string{

        $this->updateSettings($request->site_settings);
        if(isset($request->site_settings['google_recaptcha'])){
           if($request->site_settings['google_recaptcha']['status'] == (StatusEnum::true)->status()){
              Settings::where('key','default_recaptcha')->update(
                [
                    'value' => (StatusEnum::false)->status()
                ]
                );
           }
        };
        optimize_clear();

        return json_encode([
            'status'  =>  true,
            'message' => translate('Plugin Setting has been updated')
        ]);
    }

    public function envatoPluginSetting(Request $request) : string
    {
        $social_login = json_decode(site_settings('social_login'), true);
        if (isset($request->site_settings['social_login']['envato_oauth'])) {

            $social_login['envato_oauth'] = array_merge(
                $social_login['envato_oauth'] ?? [], 
                $request->site_settings['social_login']['envato_oauth']
            );
        }
        try {
            Settings::updateOrInsert(
                ['key' => 'social_login'],
                ['value' => json_encode($social_login)]
            );
        } catch (\Throwable $th) {
        }
        optimize_clear();
        return json_encode([
            'status' => true,
            'message' => translate('Envato Plugin Setting has been updated'),
        ]);
    }

    

    /**
     * Uppdate and store ticket settings
     * 
     * @return string
     */
    public function ticketInput(Request $request): string{


        $status   = true;

        try {

            $validator = $this->ticketRequestValidation($request); 
            if ($validator->fails()) return json_encode(['status' => false,'errors'=>$validator->errors()->all()]);

            $message             = translate('Updated successfully');
            $settings            = collect(json_decode(site_settings('ticket_settings')));
          
            switch (true) {
                case request()->routeIs("admin.setting.ticket.store");
                      request()->merge(['name'=> t2k($request->input("labels")),'default'=> StatusEnum::false->status()]);
                      $settings->prepend((object)($request->except(['_token'])));
                    break;
                
                default:

                    $setting =  $settings->firstWhere('name',$request->input("name"));

                    if($setting){
                        $default = $setting->default;
                        request()->merge([   
                            'type'     => $default == StatusEnum::true->status() 
                                                        ? $setting->type  
                                                        : $request->input('type'),
                            'multiple' => $default == StatusEnum::true->status() 
                                                        ? $setting->multiple
                                                        : $request->input('multiple',StatusEnum::false->status()),
                            'required' => $default == StatusEnum::true->status() 
                                                        ? $setting->required
                                                        : $request->input('required'),
                            'default'  => $default == StatusEnum::true->status() 
                                                        ? $setting->default
                                                        : StatusEnum::false->status(),
                      
                        ]);
       

                           $settings->map(function(object $object): object{

                              if($object->name  == request()->input('name')) {

                                    $object->labels        = request()->input("labels");
                                    $object->type          = request()->input("type");
                                    $object->width         = request()->input("width");
                                    $object->name          =  $object->default  == StatusEnum::true->status() 
                                                                ? $object->name
                                                                : t2k(request()->input("labels"));
                                    $object->required      = request()->input("required");
                                    $object->visibility    = request()->input("visibility");
                                    $object->placeholder   = request()->input("placeholder");
                                    $object->multiple      = request()->input("multiple");
                                    $object->default       = request()->input("default");
                                    $object->option_value  = request()->input("option_value",[]);
                                    $object->option        = request()->input("option",[]);
                              }
               
                              return     $object;
                        });                                        
                    }
                
              
                    break;
            }
    
            Settings::where('key', 'ticket_settings')->update([
                'value' => $settings 
            ]);
    
        } catch (\Exception $ex) {
            $status   = false;
            $message  = strip_tags($ex->getMessage());
        }

        optimize_clear();

        $response = [
            'status'            => $status,
            'message'           => $message,
        ];
        if($status) $response["cards_html"] = view('admin.setting.partials.ticket_field_card',[
            'ticketSettings' => json_decode(site_settings('ticket_settings'),true)
        ])->render();

        return json_encode($response);
        

    }




    /**
     * Ticket request validation
     *
     * @param Request $request
     * @return \Illuminate\Validation\Validator
     */
    public function ticketRequestValidation(Request $request): \Illuminate\Validation\Validator{

     
        $settings            = collect(json_decode(site_settings('ticket_settings')));

        $setting             = $settings->when(request()->routeIs("admin.setting.ticket.input.update"),
                                        fn(Collection $collection) :Collection => $collection->where("name",'!=',request()->input("name")))
                                        ->where('labels',$request->input("labels"))->first();

                                        $fileTypes = getInputTypes();

                                        $fileTypes = Arr::prepend($fileTypes, 'file');


        return \Validator::make($request->all(),[
            'labels'                      => ['required',function ($attribute, $value, $failed) use($setting): void{
                                                    if($setting) $failed(translate('The Label must be unique'));
                                                }],
                                            
            'type'                        => ['required',Rule::in($fileTypes)],
            'option.*'                    => [Rule::requiredIf(function() use ($setting) : bool{
                                                    if(in_array(request()->input('type'),['select','radio','checkbox'])){
                                                        if(@$setting && $setting->default == StatusEnum::true->status()){
                                                            return false;
                                                        }
                                                        return true;
                                                    }
                                                    return false;
                                            })],
            'option_value.*'               => [Rule::requiredIf(function() use ($setting) : bool{
                                                    if(in_array(request()->input('type'),['select','radio','checkbox'])){
                                                        if(@$setting && $setting->default == StatusEnum::true->status()){
                                                            return false;
                                                        }
                                                        return true;
                                                    }
                                                    return false;
                                            })],
            'required'                    => ['required',Rule::in(StatusEnum::toArray())],
            'placeholder'                 => ['required','max:191'],
            'default'                     => ['nullable',Rule::in(StatusEnum::toArray())],
            'multiple'                    => [Rule::requiredIf(function() use ($setting) : bool{
                                                        if(in_array(request()->input('type'),['select'])){
                                                            if(request()->routeIs("admin.setting.ticket.input.update") && @$setting && @$setting->default == StatusEnum::false->status()){
                                                                return true;
                                                            }
                                                            elseif(request()->routeIs("admin.setting.ticket.store")){
                                                                return true; 
                                                            }
                                                        }
                                                   
                                                    return false;
                                            }),Rule::in(StatusEnum::toArray())],
            'name'                        => [ Rule::requiredIf(fn() => request()->routeIs("admin.setting.ticket.input.update"))],
        ],
        [
            'labels.required'             => translate('Labels Field Is Required'),
            'type.required'               => translate('Type Field Is Required'),
            'required.required'           => translate('Required Field Is Required'),
            'placeholder.required'        => translate('Placeholder Field Is Required'),
            'default.required'            => translate('Default Field Is Required'),
            'multiple.required'        => translate('Please select an option between multiselect or sigle select'),
            'option.*.required'        => translate('The Display Name is required'),
            'option_value.*.required'   => translate('The option Value field is required')
        ]);

         

    }




    /**
     * Delete a specific input form ticket input list
     *
     * @param string $name
     * @return array
     */
    public function ticketInputDelete(string $name): array{

        $settings            = collect(json_decode(site_settings('ticket_settings')));

        Settings::where('key', 'ticket_settings')
                                ->update(['value' => $settings->reject(fn (object $object) :bool => ($object->name == $name &&  $object->default == StatusEnum::false->status()))]);
        optimize_clear();

        return [

            'message'      => translate('Deleted succesfully'),
            'status'       => true,
            'cards_html'   => view('admin.setting.partials.ticket_field_card',[
                'ticketSettings' => json_decode(site_settings('ticket_settings'),true)
            ])->render()
        ];
    }



    
    /**
     * Edit a specific ticket input field
     *
     * @param Request $request
     * @return array
     */
    public function ticketInputEdit(Request $request): array{

        $input     =  collect(json_decode(site_settings('ticket_settings')))
                                            ->firstWhere('name',$request->input("name"));

        if(!$input) return ['status' => false , 'message' => translate("Invalid input name")];
        return (['status' => true ,"edit_html" => view('admin.setting.partials.edit_input_field',compact('input'))->render()]);
    
    }


    public function ticketInputOrder(Request $request) : array{

        $settings     =  collect(json_decode(site_settings('ticket_settings')))->keyBy('name');

        $settings     =  collect($request->input('card_index'))->map(fn (string $key): object=>    $settings->get($key));


        Settings::where('key', 'ticket_settings')->update([
            'value' => $settings 
        ]);
        
        optimize_clear();
  
        return [

            'status'       => true,
            'cards_html'   => view('admin.setting.partials.ticket_field_card',[
                'ticketSettings' => json_decode(site_settings('ticket_settings'),true)
            ])->render()
        ];

    }


    

    /**
     * update logo settings
     * @return string
     */
    public function logoSetting(Request $request) :string{

        $request->validate([
            'site_settings.site_logo_lg'   =>  ['image', new FileExtentionCheckRule(json_decode(site_settings('mime_types'),true))],
            'site_settings.site_logo_sm'   =>  [ 'image' ,new FileExtentionCheckRule(json_decode(site_settings('mime_types'),true))],
            'site_settings.site_favicon'   =>  [ 'image', new FileExtentionCheckRule(json_decode(site_settings('mime_types'),true))],
            'site_settings.frontend_logo'  =>  [ 'image', new FileExtentionCheckRule(json_decode(site_settings('mime_types'),true))]
        ],
        );

        $logo_section =  [];

        if ( isset($request['site_settings']['site_logo_lg']) && is_file($request['site_settings']['site_logo_lg']->getPathname())) {
            $site_logo = site_settings('site_logo_lg');
            try {
                $logo_section ['site_logo_lg'] =   storeImage($request['site_settings']['site_logo_lg'], getFilePaths()['site_logo']['path'], null,   $site_logo);
            } catch (\Throwable $th) {
            }
        }

        if ( isset($request['site_settings']['site_logo_sm']) && is_file($request['site_settings']['site_logo_sm']->getPathname())) {
            $site_logo = site_settings('site_logo_sm');
            try {
                $logo_section ['site_logo_sm'] =   storeImage($request['site_settings']['site_logo_sm'], getFilePaths()['site_logo']['path'], null,   $site_logo);
            } catch (\Throwable $th) {

            }

        }

        if ( isset($request['site_settings']['site_favicon']) && is_file($request['site_settings']['site_favicon']->getPathname())) {
            $site_logo = site_settings('site_favicon');
            try {
                $logo_section ['site_favicon'] =   storeImage($request['site_settings']['site_favicon'], getFilePaths()['site_logo']['path'], null,   $site_logo);
            } catch (\Throwable $th) {

            }
        }

        if ( isset($request['site_settings']['frontend_logo']) && is_file($request['site_settings']['frontend_logo']->getPathname())) {
            $site_logo = site_settings('frontend_logo');
            try {
                $logo_section ['frontend_logo']  =   storeImage($request['site_settings']['frontend_logo'], getFilePaths()['site_logo']['path'], null,   $site_logo);
            } catch (\Throwable $th) {

            }
        }

        $this->updateSettings($logo_section);

        optimize_clear();

        return json_encode([
            'status'  => true,
            'message' => translate('logo  has been updated')
        ]);

    }

    /**
     * update  settings
     * @return string
     */
    public function store(Request $request) :string
    {
        $validations = $this->settings_validations($request->site_settings);
        $request->validate( $validations['rules'],$validations['message']);

        if(isset($request->site_settings['time_zone'])){
            $timeLocationFile = config_path('timesetup.php');
            $time = '<?php $timelog = '.$request->site_settings['time_zone'].' ?>';
            file_put_contents($timeLocationFile, $time);
        }
        $this->updateSettings($request->site_settings);
        optimize_clear();

        return json_encode([
            'status'  =>  true,
            'message' => translate('System Setting has been updated')
        ]);

    }

    /**
     * update  settings
     * @param array $request_data
     * @return RedirectResponse
     */
    public function updateSettings(array $request_data) :void{

        foreach(($request_data) as $key=>$value){

            if($key == 'aws_s3' || $key == 'pusher_settings' || $key == 'social_login' || $key == 'google_recaptcha' ||  $key == 'ticket_duplicate_status' ) {
                
                $value = json_encode($value);
            }

           try {

                Settings::updateOrInsert(
                    ['key'    => $key],
                    ['value'  => $value]
                );
           } catch (\Throwable $th) {

           }
        }
        optimize_clear();
    }


    /**
     * clear cache
     * @return RedirectResponse
     */
    public function cacheClear() :RedirectResponse
    {
        optimize_clear();
        return back()->with('success',translate('Cache Cleared Successfully'));
    }

    /**
     * clear cache
     * @return View
     */
    public function systemInfo() :View
    {

        $title = "System Information";
        $systemInfo = [
            'laravel_version' => app()->version(),
            'server_detail'   => $_SERVER,
        ];
        return view('admin.system_info',compact('title','systemInfo'));
    }

    /**
     * settings validations
     * @return array
     */
    public function settings_validations(array $request_data ,string $key = 'site_settings') :array{

        $rules = [];
        $message = [];
        foreach(array_keys($request_data) as $data){

            $rules[$key.".".$data] ='required';
            $message[$key.".".$data.'.required'] = ucfirst(str_replace('_',' ',$data)).' '.translate('Feild is Required');
        }

        return [
            'rules'    =>  $rules,
            'message'  => $message
        ];
    }


    /**
     * update setting status
     * @return JsonResponse
     */
    public function settingsStatusUpdate(Request $request) : JsonResponse{


        if($request->data['key'] == 'force_ssl' &&  $request->data['status'] ==  (StatusEnum::true)->status() &&  !$request->secure()){

            $response['status']  = false;

            $response['message'] = translate('Your Request is not secure to enable this feature');
            return response()->json($response);

        }

        Settings::updateOrInsert(
            ['key'   => $request->data['key'] ],
            ['value' =>  $request->data['status']]
        );

        if($request->data['key'] == 'app_debug'){
            
            $response['reload']  = true;
            if($request->data['status'] ==  (StatusEnum::true)->status()){
                update_env("APP_DEBUG","true");
            }
            else{
                update_env("APP_DEBUG","false");
            }
        }

        if($request->data['key'] == 'default_recaptcha' &&  $request->data['status'] ==  (StatusEnum::true)->status()){

            $google_recaptcha           =  json_decode(site_settings('google_recaptcha'),true);
            $google_recaptcha['status'] =  (StatusEnum::false)->status();
            Settings::where('key','google_recaptcha')->update([
                'value' => json_encode($google_recaptcha )
            ]);
        }


        if (
            ($request->data['key'] == 'auto_ticket_assignment' || $request->data['key'] == 'group_base_ticket_assign')
            && $request->data['status'] == (StatusEnum::true)->status()
        ) {
            $updateKey = ($request->data['key'] == 'auto_ticket_assignment') ? 'group_base_ticket_assign' : 'auto_ticket_assignment';
            $response['reload']  = true;
            Settings::where('key', $updateKey)->update([
                'value' => (StatusEnum::false)->status()
            ]);
        }



        optimize_clear();
        $response['status']  = true;

        $response['message'] = translate('Status Updated Successfully');
        return response()->json($response);
    }



    /** system update  */

     public function sysyemUpdate() :RedirectResponse{

        $status = 'error';
        try {
            $status     = 'success';
            $message    = 'Your system is currently running the latest version.';

            $newVersion = (double) Arr::get(config("requirements")['core'],'appVersion',1.0);
     
            if(check_for_update()){

                $migrations = [
                    "database/migrations/2024_01_06_130912_add_column_to_ticket_table.php",
                ];
                
                Artisan::call('db:seed',[
                    '--force' => true
                ]);

                foreach($migrations as $migration){
                    Artisan::call('migrate', [
                        '--force' => true,
                        '--path' => $migration,
                    ]);
                }
    
                Log::info('Database seeder and migration executed');
                Settings::updateOrInsert(
                    ['key'    => "app_version"],
                    ['value'  => $newVersion]
                );
                optimize_clear();
                $message    = 'System updated successfully';
            }
        } catch (\Exception $ex) {
            $message = \strip_tags( $ex->getMessage());
        }

        return back()->with($status,translate($message));
    }



    /**
     * update pluging settings
     * @return string
     */
    public function businessHour(Request $request) :string{

      
        $days =  [
            'Mon' =>  'Monday',
            'Tue' =>  'Tuesday',
            'Wed' =>  'Wednesday',
            'Thu' =>  'Thursday',
            'Fri' =>  'Friday',
            'Sat' =>  'Saturday',
            'Sun' =>  'Sunday',
        ];

        $request->validate([
            'operating_day'   => ['nullable','array'],
            'operating_day.*' => ['nullable',Rule::in(array_keys($days))],
            'start_time'      => ['required','array'],
            'end_time'        => ['required','array'],

        ],[
            'end_time.*.required'   => translate('Please select end time'),
            'start_time.*.required' => translate('Please select start time'),
        ]);

     



        $businessHour = collect($days)->map(function(string $day , string $key) use($request){
          
            return [
                'is_off'     =>  in_array($key,$request->input('operating_day',[])) ,
                'start_time' =>  Arr::get($request->input('start_time',[]),$key) ,
                'end_time'   =>  Arr::get($request->input('end_time',[]),$key) ,
            ];

        })->all();


        Settings::updateOrInsert(
            ['key'    => 'business_hour'],
            ['value'  => json_encode($businessHour)]
        );
   
        optimize_clear();

        return json_encode([
            'status'  =>  true,
            'message' => translate('Setting has been updated')
        ]);


    }



}
