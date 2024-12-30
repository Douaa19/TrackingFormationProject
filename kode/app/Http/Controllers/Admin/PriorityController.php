<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\PriorityRequest;
use App\Models\Priority;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

use Illuminate\Validation\Rule;
class PriorityController extends Controller
{
    


    /**
     * get priorites list
     *
     * @return View
     */
    public function index() :View{

        return view('admin.priority.index',[
            'priorities' => Priority::latest()->get(),
            'title'      => "Manange Priority",
        ]);
    }





    /**
     * create priority
     *
     * @return View
     */
    public function create() :View{

        return view('admin.priority.create',[

            'priorities' => Priority::latest()->get(),
            'title'      => "Create Priority",
        ]);
    }





    /**
     * Store A Priority
     *
     * @param PriorityRequest $request
     * @return RedirectResponse
     */
    public function store(PriorityRequest $request) :RedirectResponse {

        $priority                 =  new Priority();
        $priority->name           =  $request->input('name');
        $priority->response_time  =  $request->input('response');
        $priority->resolve_time   =  $request->input('resolve');
        $priority->color_code     =  $request->input('color_code');
        $priority->save();

        return back()->with("success",translate("Priority Created Successfully"));

    }


   /**
     * create priority
     *
     * @return View
     */
    public function edit(int|string $id) :View{

        return view('admin.priority.edit',[

            'priority' => Priority::with(['ticket'])
            ->where('id',$id)
            ->latest()
            ->firstOrFail(),

            'title'      => "Update Priority",
        ]);
    }


    /**
     * Update A Priority
     *
     * @param PriorityRequest $request
     * @return RedirectResponse
     */
    public function update(PriorityRequest $request) :RedirectResponse {

        $priority                 =  Priority::with(['ticket'])
        ->where('id',$request->input("id"))
        ->latest()
        ->firstOrFail();
        $priority->name           =  $request->input('name');
        $priority->response_time  =  $request->input('response');
        $priority->resolve_time   =  $request->input('resolve');
        $priority->color_code     =  $request->input('color_code');
        $priority->save();

        return back()->with("success",translate("Priority Updated Successfully"));

    }




    /**
     * Update Status
     *
     * @param int $id 
     * @return JsonResponse
     */
    public function statusUpdate(Request $request) :JsonResponse {

        $modelInfo = [
            'table'  => (new Priority())->getTable(),
            'key'    => "id",
            'values' => StatusEnum::toArray()
        ];

        validateModelStatus($request,$modelInfo);

        $priority                = Priority::where('id',$request->data['id'])->firstOrfail();
        $priority->status        = $request->data['status'];
        $priority->save();
        $response['status']      = true;
        $response['reload']      = true;
        $response['message']     = translate('Status Updated Successfully');

        return response()->json($response);


        
    }


      /**
     * Update Status
     *
     * @param int $id 
     * @return JsonResponse
     */
    public function setDefault(Request $request) :JsonResponse {

        $modelInfo = [
            'table'  => (new Priority())->getTable(),
            'key'    => "id",
            'values' => StatusEnum::toArray()
        ];

        validateModelStatus($request,$modelInfo);

        Priority::where('id','!=',$request->data['id'])->update([
           'is_default'=> (StatusEnum::false)->status()
        ]);

        Priority::where('id',$request->data['id'])->update([
           'is_default'=>(StatusEnum::true)->status(),
        ]);


        $response['status']          = true;
        $response['reload']          = true;
        $response['message']         = translate('Status Updated Successfully');
        return response()->json($response);


        
    }






    /**
     * Destory A Priority
     *
     * @param int | string $id
     * @return RedirectResponse
     */
    public function destroy(int | string $id) :RedirectResponse {


        $status        = 'error';
        $message       = translate('Can Not Deleted!! This Priority Has lots Of Relational Data Under it');

        $priority      = Priority::withCount(['ticket'])
        ->where('id',$id)
        ->latest()
        ->firstOrFail();


        if($priority->ticket_count == 0){

            $status    = 'success';
            $message   = translate('Priority Deleted!!');
            $priority->delete();
        }


        return back()->with($status,$message );

    }
    
}
