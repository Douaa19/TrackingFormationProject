<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class PageController extends Controller
{
    
    /**
     * PagesList
     *
     * @return View
     */
    public function index() :View {

        return view('admin.page.index',[
            'title' => "Pages",
            'pages' =>  Page::latest()->get()
        ]);
        
    }

    /**
     * Store a New Canned Reply
     *
     * @return RedirectResponse
     */
    public function store(Request $request) :RedirectResponse {

        $request->validate([
            'title'      => 'required|unique:pages,title',
            'description'=> 'required',
        ],[
            'title.required'       => translate('Title Field Is Required'),
            'title.unique'         => translate('Title Field Must Be Unique'),
            'description.required' => translate('Description Field Is Required'),
        ]);

        Page::create([
            'title'       =>  $request->title,
            'slug'        =>  Str::slug($request->title,'-'),
            'description' =>  $request->description,
            'status'      =>  (StatusEnum::true)->status()
        ]);

        return back()->with('success', translate('Pages Created Successfully'));
    }


    /**
     * edit a page
     * 
     * @param int $id
     *
     */
    public function edit(int | string $id) :View {

        return view('admin.page.edit',[
            'title'  => "Page Edit",
            'page'   => Page::where('id',$id)->firstOrFail()
        ]);
    }


    /**
     * Update a page
     *
     */
    public function update(Request $request) :RedirectResponse {

        $request->validate([
            'title'       => 'required|unique:pages,title,'.$request->id,
            'description' => 'required',
        ],[
            'title.required'       => translate('Title Field Is Required'),
            'title.unique'         => translate('Title Field Must Be Unique'),
            'description.required' => translate('Description Field Is Required'),
        ]);

        Page::where('id',$request->id)->update([

            'title'        =>  $request->title,
            'slug'         =>  Str::slug($request->title,'-'),
            'description'  =>  ($request->description),
            'status'       =>  (StatusEnum::true)->status()
        ]);

        return back()->with('success', translate('Page Updated Successfully'));
    }
    

    /**
     * Update Status
     *
     * @param int $id 
     * @return JsonResponse
     */
    public function statusUpdate(Request $request) :JsonResponse {

        $modelInfo = [
            'table'  => (new Page())->getTable(),
            'key'    => "id",
            'values' => StatusEnum::toArray()
        ];
        validateModelStatus($request,$modelInfo);

        $page                =  Page::where('id',$request->data['id'])->first();
        $page->status        = $request->data['status'];
        $page->save();
        $response['status']  = true;
        $response['reload']  = true;
        $response['message'] = translate('Status Updated Successfully');
        return response()->json($response);
        
    }

    /**
     * Delete a page
     * 
     * @param int $id
     *
     */
    public function destroy(int | string $id) :RedirectResponse {

        Page::where('id',$id)->delete();
        return back()->with('success', translate('Deleted Successfully'));
    }

}
