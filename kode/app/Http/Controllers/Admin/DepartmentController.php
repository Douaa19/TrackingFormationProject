<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Rules\General\FileExtentionCheckRule;
use App\Rules\General\FileLengthCheckRule;
use App\Traits\EnvatoManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

class DepartmentController extends Controller
{

    use EnvatoManager;


    /**
     * department list
     *
     * @return View
     */
    public function index() :View {

        return view('admin.department.index',[

            'title'                 => "Manage Product",
            'departments'           => Department::latest()->get()
                                      
        ]);
        
    }




    /**
     * Store a department
     *
     * @return RedirectResponse
     */
    public function store(Request $request) :RedirectResponse {


        $request->validate([
            "name"      => ["required","unique:departments,name,".request()->id],
            'image'                 => [
                'image',
                new FileExtentionCheckRule(json_decode(site_settings('mime_types'), true)),
            ],
            'description' => 'required',
        ],[
            'name.required'        =>  translate('Default name is required'),
            'name.unique'          =>  translate('Default name must be unique'),
        ]);



        if($request->hasFile('image')){

            try{
                $image = storeImage($request->file('image'), getFilePaths()['department']['path'], null);
            }catch (\Exception $exp){
                return back()->with('error', translate("Unable to upload file. Check directory permissions"));
            }
        }
        $department                   = new Department();
        $department->name             = $request->input('name');
        $department->description      = $request->input('description');
        $department->status           = StatusEnum::true->status();
        $department->slug             = make_slug($request->input('name'));
        $department->image            = @$image;
        
        
        $department->save();

        return back()->with('success', translate('Product created successfully'));
    }

 

    /**
     * Update a department
     *
     * @return RedirectResponse
     */
    public function update(Request $request) :RedirectResponse {

        $request->validate([
            "name"      => ["required","unique:departments,name,".request()->id],
            'image'                 => [
                'image',
                new FileExtentionCheckRule(json_decode(site_settings('mime_types'), true)),
            ],
            'description' => 'required',
        ],[
            'name.required'        =>  translate('Default name is required'),
            'name.unique'          =>  translate('Default name must be unique'),
        ]);

        $department                   = Department::findOrFail($request->input('id'));
        $department->name             = $request->input('name');
        $department->slug             = make_slug($request->input('name'));
        $department->description      = $request->input('description');
    
        $image             =  $department->image;

        if($request->hasFile('image')){
            try{
                $image     = storeImage($request->file('image'), getFilePaths()['department']['path'], null ,$department->image);
            }catch (\Exception $exp){
                return back()->with('error', translate("Unable to upload file. Check directory permissions"));
            }
        }

        $department->image             = $image;

        $department->save();


        return back()->with('success', translate('Product updated successfully'));
    }
    

    /**
     * Update Status
     *
     * @param int $id 
     * @return JsonResponse
     */
    public function statusUpdate(Request $request) :JsonResponse {

        $modelInfo = [
            'table'  => (new Department())->getTable(),
            'key'    => "id",
            'values' => StatusEnum::toArray()
        ];
        
        validateModelStatus($request,$modelInfo);
       
        $status               =  Department::where('id',$request->data['id'])->first();
        $status->status       =  $request->data['status'];
        $status->save();
        $response['status']   = true;
        $response['reload']   = true;
        $response['message']  = translate('Status Updated Successfully');

        return response()->json($response);
        
    }


  
    /**
     * Delete a department
     * 
     * @param int $id
     *
     */
    public function destroy(int | string $id) :RedirectResponse {
        
        $department               =  Department::withCount(['tickets','knowledgeBases'])
                                                 ->where('id',$id)->firstOrFail();

 
        if( 0 < $department->tickets_count  ||   0 < $department->knowledge_bases_count){
            return back()->with('error', translate('Unable to delete the Product at this time due to the extensive amount of related data associated with it.'));
        }

        if($department->image){
            remove_file(getFilePaths()['department']['path'], $department->image);
        }
        $department->delete();

        return back()->with('success', translate('Deleted Successfully'));
    }
  
}
