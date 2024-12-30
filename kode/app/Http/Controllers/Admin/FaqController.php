<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Faq;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
class FaqController extends Controller
{
    
    /**
     * faq List
     *
     * @return View
     */
    public function index() :View {

        return view('admin.faq.index',[

            'title'       => "Faq Settings",
            'categories'  => Category::active()->get(),
            'faqs'        => Faq::with(['category'])->latest()->get()
        ]);
        
    }


    
    /**
     * edit a faq
     * 
     * @param int $id
     *
     */
    public function edit(int | string $id) :View {

        return view('admin.faq.edit',[

            'title'      => "Faq Edit",
            'categories' => Category::active()->get(),
            'faq'        => Faq::where('id',$id)->first()
        ]);
    }

    /**
     * Store a New faq
     *
     * @return RedirectResponse
     */
    public function store(Request $request) :RedirectResponse {

        $request->validate([
            'question'    => 'required',
            'answer'      => 'required',
            'category_id' => 'required|exists:categories,id',
        ],[
            'question.required'    => translate('Question Field Is Required'),
            'answer.required'      => translate('Answer Field Is Required'),
            'category_id.required' => translate('Category Field Is Required'),
            'category_id.exists'   => translate('Selected Category Is Invalid'),
        ]);

        Faq::create([

            'question'      => $request->question,
            'answer'        => $request->answer,
            'category_id'   => $request->category_id,
            'status'        => (StatusEnum::true)->status()
        ]);

        return back()->with('success', translate('Faq Created Successfully'));
    }

 

    /**
     * Update a Faq
     *
     */
    public function update(Request $request) :RedirectResponse {

        $request->validate([
            'question'    => 'required',
            'answer'      => 'required',
            'category_id' => 'required|exists:categories,id',
        ],[
            'question.required'     => translate('Question Field Is Required'),
            'answer.required'       => translate('Answer Field Is Required'),
            'category_id.required'  => translate('Category Field Is Required'),
            'category_id.exists'    => translate('Selected Category Is Invalid'),
        ]);

        Faq::where('id',$request->id)->update([
            'question'     => $request->question,
            'answer'       => $request->answer,
            'category_id'  => $request->category_id,
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
            'table'  => (new Faq())->getTable(),
            'key'    => "id",
            'values' => StatusEnum::toArray()
        ];
        validateModelStatus($request,$modelInfo);

        $faq                  =  Faq::where('id',$request->data['id'])->first();
        $faq->status          = $request->data['status'];
        $faq->save();
        $response['status']   = true;
        $response['reload']   = true;
        $response['message']  = translate('Status Updated Successfully');

        return response()->json($response);
        
    }

    /**
     * Delete a faq
     * 
     * @param int $id
     *
     */
    public function destroy(int | string $id) :RedirectResponse {
        
        Faq::where('id',$id)->delete();
        return back()->with('success', translate('Deleted Successfully'));
    }
}
