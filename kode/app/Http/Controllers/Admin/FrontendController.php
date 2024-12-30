<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Frontend;
use App\Rules\General\FileExtentionCheckRule;
use App\Rules\General\FileLengthCheckRule;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
class FrontendController extends Controller
{


    public function index() :View
    {
        $title     = "Manage frontend section";
        $frontends = Frontend::orderBy('id')->get();
        return view('admin.frontend.index', compact('title', 'frontends'));
    }

    public function update(Request $request, $id) :RedirectResponse
    {
      
        $frontends       = Frontend::where('id',$id)->first();
        $section_values  = json_decode($frontends->value,true);
        $input_data      = $request->frontend;
        $validation      = [];


        if(isset( $section_values['static_element']['banner_image']) ){

            $size       = explode('x',  $section_values['static_element']['banner_image']['size']);
            $validation = [
                'frontend.static_element.banner_image.value' => ["image",new FileExtentionCheckRule(json_decode(site_settings('mime_types'),true))],
            ];
            $request->validate($validation);
            $input_data['static_element']['banner_image']['value'] = $section_values['static_element']['banner_image']['value'];
        }
      
        if($request->hasFile('frontend.static_element.banner_image.value')){
            
            $request->validate($validation);
            try{
                $image = storeImage($request->file('frontend.static_element.banner_image.value'), getFilePaths()['frontend']['path'],null, $section_values['static_element']['banner_image']['value']);
             
            }catch (\Exception $exp){
                return back()->with('error', translate("Unable to upload file. Check directory permissions"));
            }

            $input_data['static_element']['banner_image']['value'] =    $image ;
            
        }

        $frontends->status   =  $request->status;;
        $frontends->value    = json_encode($input_data);
        $frontends->save();

        optimize_clear();

        return back()->with('success',translate("Frontend Section Updated Successfully"));
        
       
    }
    
}
