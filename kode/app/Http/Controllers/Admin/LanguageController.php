<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LanguageRequest;
use App\Http\Services\Admin\LanguageService;
use Illuminate\Http\Request;
use App\Models\Language;
class LanguageController extends Controller
{

    public $languageService;

    /**
     * Constructs a new instance of the LanguageController class.
     *
     * @return void
     */
    public function __construct()
    {
        $this->languageService = new LanguageService();
    }


    /**
     * Display the language management page.
     *
     */
    public function index() :\Illuminate\Contracts\View\View
    {
        return view('admin.language.index', [
            'title'         =>  translate("Manage language"), 
            'languages'     =>   $this->languageService->index(),
            'countryCodes'  => json_decode(file_get_contents(resource_path(config('constants.options.country_code')) . 'countries.json'),true)
        ]);
    }

    /**
     * Store a new language.
     *
     * @param LanguageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LanguageRequest $request) :\Illuminate\Http\RedirectResponse
    {
        $response = $this->languageService->store($request);
        return back()->with($response['status'],$response['message']);
    }

    /**
     * Make a language as default
     * 
     * @param int|string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setDefaultLang(int | string $id) :\Illuminate\Http\RedirectResponse {
        $response = $this->languageService->setDefault($id); 
        return back()->with($response['status'],$response['message']);
    }

    /**
     * Updates the status of a language.
     *
     */
    public function statusUpdate(Request $request) :string{

       
        $modelInfo = [
            'table'  => (new Language())->getTable(),
            'key'    => "id",
            'values' => StatusEnum::toArray()
        ];

        validateModelStatus($request,$modelInfo);

        $language = Language::where('id',$request->data['id'])->first();
        $response['reload'] = true;

        if(session()->get('locale')  == $language->code){
            $response['status']      = false;
            $response['message']     = translate('System Current Language Status Cant not be Updated');
        }
        else{
            if($language->is_default == (StatusEnum::true)->status()){
                $response['status']  = false;
                $response['message'] = translate('You Can not Update Default language Status');
            }
            else{
                $response            = update_status($language->id,'Language',$request->data['status']);
                $response['reload']  = true;
            }
        }
        return json_encode($response);
    }

    /**
     * Display the language translation page.
     *
     * @param  string $code
     */
    public function translate(string $code) :\Illuminate\Contracts\View\View{

        return view('admin.language.translate', [

            'title' =>  translate("Translate language"), 
            'translations'=>  $this->languageService->translationVal($code)

        ]);
    }

    /**
     * Translate a specific lang key.
     *
     */
    public function tranlateKey(Request $request) :string{

        $response = $this->languageService->translateLang($request);

        return json_encode([
            
            "success" => $response
        ]);
    }

    /**
     * Destroy A language
     * 
     * @param int|string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int | string $id) :\Illuminate\Http\RedirectResponse
    {
        $response = $this->languageService->destory($id);
        return back()->with( $response['status'],$response['message']);
    }

    /**
     * Destroy A language transaltion
     * 
     * @param int|string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyTranslateKey(int | string $id) :\Illuminate\Http\RedirectResponse {
        
        $response = $this->languageService->destoryKey($id);
        return back()->with( $response['status'],$response['message']);
    }

}
