<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\CannedReply;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class CannedController extends Controller
{
    
    
    /**
     * canned reply  List
     *
     * @return View
     */
    public function index() :View {

        return view('admin.canned_reply.index',[

            'title'        => "Canned Reply",
            'admins'       => Admin::where("id",'!=',auth_user()->id)->active()->get(),
            'cannedReply'  => CannedReply::with(['admin'])
                                            ->latest()
                                            ->where("admin_id",auth_user()->id)
                                            ->get()
        ]);

        
    }

    /**
     * Store a New Canned Reply
     *
     * @return RedirectResponse
     */
    public function store(Request $request) :RedirectResponse {

        $request->validate([

            'title'  =>'required',
            'body'   =>'required',
        ],[
            'title.required' => translate('Title Field Is Required'),
            'body.required'  => translate('Body Field Is Required'),
        ]);

        CannedReply::create([
            
            'title'     => $request->title,
            'body'      => build_dom_document($request->body)['html'],
            'admin_id'  => auth_user()->id,
            'status'    => (StatusEnum::true)->status()
        ]);

        return back()->with('success', translate('Replay Created Successfully'));
    }

 

    /**
     * Update a Replay
     *
     * @return RedirectResponse
     */
    public function update(Request $request) :RedirectResponse {

        $request->validate([
            'id'      => 'required | exists:canned_replies,id',
            'title'   => 'required',
            'body'    => 'required',
        ],[
            'id.required'     => translate('Id Field Is Required'),
            'id.exists'       => translate('Invalid Id'),
            'title.required'  => translate('Title Field Is Required'),
            'body.required'   => translate('Body Field Is Required'),
        ]);

        CannedReply::where('id',$request->id)->update([
            
            'title'      => $request->title,
            'body'       => build_dom_document($request->body)['html'],
        
        ]);

        return back()->with('success', translate('Replay Updated Successfully'));
    }
    

    /**
     * Update Status
     *
     * @param int $id 
     * @param Enum $status
     * @return JsonResponse
     */
    public function statusUpdate(Request $request) :JsonResponse {

        $modelInfo = [
            'table'  => (new CannedReply())->getTable(),
            'key'    => "id",
            'values' => StatusEnum::toArray()
        ];
        
        validateModelStatus($request,$modelInfo);
       
        $canned               =  CannedReply::where('id',$request->data['id'])->first();
        $canned->status       =  $request->data['status'];
        $canned->save();
        $response['status']   = true;
        $response['reload']   = true;
        $response['message']  = translate('Status Updated Successfully');

        return response()->json($response);
        
    }

    /**
     * Delete a Reply
     * 
     * @param int $id
     *
     */
    public function destroy(int | string $id) :RedirectResponse {
        
        CannedReply::where('id',$id)->delete();
        return back()->with('success', translate('Deleted Successfully'));
    }




    public function share(Request $request) :RedirectResponse {

        $request->validate([
            'id'          => 'required|exists:canned_replies,id',
            'admin_ids'   => 'required|array',
            'admin_ids.*' => 'required|exists:admins,id'
        ]);

        CannedReply::where('id',$request->input('id'))
                    ->where("admin_id",auth_user()->id)
                    ->update(['share_with' => $request->input('admin_ids')]);
    
        return redirect()->back()->with('success', translate('Content shared successfully'));

    }

}
