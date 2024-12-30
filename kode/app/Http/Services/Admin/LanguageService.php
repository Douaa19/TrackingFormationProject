<?php

namespace App\Http\Services\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\ModelTranslation;
use App\Models\Translation;
use Illuminate\Database\Eloquent\Builder;
use OpenAI\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LanguageService extends Controller
{


    public function index()
    {
        return Language::latest()->get();
    }

    public function store($request) :array
    {
        
        $country  =  explode("//", $request->name);
        $code = $request->code?$request->code:  strtolower($country[1]);
        if(Language::where('code',$code)->exists()){
            $response['status']   = "error";
            $response['message']  = translate('This Language Is Already Added !! Try Another');
        }
        else{
            $language = Language::create([

                'name'       => $country[0],
                'code'       => $code,
                'is_default' => (StatusEnum::false)->status(),
                'status'     => (StatusEnum::true)->status()
            ]);
            try {
                $translations         = Translation::where('code', 'en')->get();
                $translationsToCreate = [];
                
                foreach ($translations as $k) {

                    $translationsToCreate[] = [
                        'code'  => $language->code,
                        'key'   => $k->key,
                        'value' => $k->value
                    ];
                }
                
                Translation::insert($translationsToCreate);
    
          
            } catch (\Throwable $th) {
                //throw $th;
            }
          



            $response['status']   = "success";
            $response['message']  = translate('Language Created Succesfully');
            $response['data']     = $language;
        }
        return $response;
    }





    public function translateLang($request) :bool{

        $response = true;

        try {
            Translation::where('id',$request->data['id'])->update([
                'value' => $request->data['value']
            ]);
            optimize_clear();
        } catch (\Throwable $th) {
            $response = false;
        }

        return $response;

    }


    public function setDefault(int | string $id) :array{

        $response['status']  = "success";
        $response['message'] = translate('Default Language Set Successfully');

        Language::where('id','!=',$id)->update([
          'is_default'=> (StatusEnum::false)->status()
        ]);

        Language::where('id',$id)->update([
          'is_default'=>(StatusEnum::true)->status(),
        ]);

        return $response;
    }



    public function destory(int | string $id) :array
    {
        $response['status']          = 'success';
        $response['message']         = translate('Deleted Successfully');

        try {
            $language = Language::where('id',$id)->first();

            if( $language->code   == 'en' || $language->is_default == StatusEnum::true){
                $response['code']    = "error";
                $response['message'] = translate('Default & English Language Can Not Be Deleted');
            }
            else{
                Translation::where("code",$language->code)
                                    ->lazyById('200','id')
                                    ->each->delete();
                ModelTranslation::where("locale",$language->code)
                                    ->lazyById('200','id')
                                    ->each->delete();
                                    
                $language->delete();
            }
      
        } catch (\Throwable $th) {

            $response['status']  = 'error';
            $response['message'] = translate('Post Data Error !! Can Not Be Deleted');
        }
        return $response;
    }
    
    public function destoryKey(int | string $id):array
    {
        $response['status']   = 'success';
        $response['message']  = translate('Key Deleted Successfully');
        try {

            $transData        = Translation::where('id',$id)->first();
            $transData->delete();
            optimize_clear();
      
        } catch (\Throwable $th) {

            $response['status'] = 'error';
            $response['message'] = translate('Post Data Error !! Can Not Be Deleted');
        }
        return $response;
    }



    
    public function translationVal(string $code)
    {

        return Translation::when(request()->input('search'),function(Builder $query) :Builder {
             $search = '%'.request()->input('search').'%';
             return $query->where('key','like',$search)
                              ->orWhere('value','like',$search);

        })->where('code',$code)->paginate(paginateNumber());


    }
    




    protected function translateKeyword($keyword)
    {


    }

}
