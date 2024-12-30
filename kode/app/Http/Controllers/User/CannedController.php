<?php

namespace App\Http\Controllers\User;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
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

        return view('user.canned_reply.index',[
            'title'       => "Canned Reply",
            'cannedReply' =>  CannedReply::with(['user'])->latest()->where("user_id",auth_user('web')->id)->paginate(paginateNumber())
        ]);
        
    }

    /**
     * Store a New Canned Reply
     *
     * @return RedirectResponse
     */
    public function store(Request $request) :RedirectResponse {

        $request->validate([
            'title'           => 'required',
            'body'            => 'required',
        ],[
            'title.required'  => translate('Title Field Is Required'),
            'body.required'   => translate('Body Field Is Required'),
        ]);

        CannedReply::create([
            'title'           => $request->title,
            'body'            => build_dom_document($request->body)['html'],
            'user_id'         => auth_user('web')->id,
            'status'          => (StatusEnum::true)->status()
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
            'id'             => 'required | exists:canned_replies,id',
            'title'          => 'required',
            'body'           => 'required',
        ],[
            'id.required'    => translate('Id Field Is Required'),
            'id.exists'      => translate('Invalid Id'),
            'title.required' => translate('Title Field Is Required'),
            'body.required'  => translate('Body Field Is Required'),
        ]);

        CannedReply::where('id',$request->id)->update([

            'title'          => $request->title,
            'body'           => build_dom_document($request->body)['html']

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
       
        $category =  CannedReply::where('id',$request->data['id'])
        ->where('user_id',auth_user('web')->id)
        ->first();

        $category->status    = $request->data['status'];
        $category->save();
        $response['status']  = true;
        $response['reload']  = true;
        $response['message'] = translate('Status Updated Successfully');

        return response()->json($response);
        
    }

    /**
     * Delete a Reply
     * 
     * @param int $id
     *
     */
    public function destroy(int | string $id) :RedirectResponse {
        
        CannedReply::where('user_id',auth_user('web')->id)->where('id',$id)->delete();
        return back()->with('success', translate('Deleted Successfully'));
    }

}
