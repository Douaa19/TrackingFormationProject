<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\KnowledgeBase;
use Illuminate\Http\Request;
use App\Rules\General\FileLengthCheckRule;
use Illuminate\Http\RedirectResponse;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class KnowledgeBaseController extends Controller
{
    /**
     * Knowledgebase  list
     *
     * @return View
     */
    public function index( ? string $slug =  null , ? int $id = null) :View {


        $departments    =  Department::with(['parentKnowledgeBases','parentKnowledgeBases.childs'])
                         
                                ->active()
                                ->get();


        $knowledge      = KnowledgeBase::find($id);
        

        return view('admin.knowledgebase.index',[
            'title'                 => "Manage Knowledgebase",                     
            'departments'           => $departments,                     
            'knowledge'             => $knowledge,                     
                
        ]);
        
    }



    /**
     * Knowledgebase  stroe
     *
     * @return RedirectResponse
     */
    public function store( Request $request) :RedirectResponse {


        $request->validate([
            'department_id'  => ['required','exists:departments,id'],
            'icon'           => ['required'],
            'name'           => ['required','unique:knowledge_bases,name'],
            'description'    => ['required'],
            'status'         => ['required',Rule::in(StatusEnum::toArray())],
        ]);


        $knowledgeBase = new KnowledgeBase();

        $description =  build_dom_document($request->input('description'));
        $knowledgeBase->department_id = $request->input('department_id');
        $knowledgeBase->icon          = $request->input('icon');
        $knowledgeBase->name          = $request->input('name');
        $knowledgeBase->slug          = make_slug($request->input('name'));
        $knowledgeBase->description   = Arr::get($description,'html');
        $knowledgeBase->status        = $request->input('status');
        $knowledgeBase->save();


        return back()->with('success','Created succcessfully');
        
    }



    /**
     * Knowledgebase  update
     *
     * @return RedirectResponse
     */
    public function update( Request $request) :RedirectResponse {


        $request->validate([
            'department_id'  => ['required','exists:departments,id'],
            'id'             => ['required','exists:knowledge_bases,id'],
            'icon'           => ['required'],
            'name'           => ['required','unique:knowledge_bases,name,'.$request->input('id')],
            'description'    => ['required'],
            'status'         => ['required',Rule::in(StatusEnum::toArray())],
        ]);


        $knowledgeBase =  KnowledgeBase::where('id',$request->input('id'))
                                        ->where('department_id',$request->input('department_id'))
                                        ->firstOrfail();

        $description =  build_dom_document($request->input('description'));
        $knowledgeBase->icon          = $request->input('icon');
        $knowledgeBase->name          = $request->input('name');
        $knowledgeBase->slug          = make_slug($request->input('name'));
        $knowledgeBase->description   = Arr::get($description,'html');
        $knowledgeBase->status        = $request->input('status');
        $knowledgeBase->save();


        return back()->with('success','Updated succcessfully');
        
    }



    /**
     * Delete a Reply
     * 
     * @param int $id
     *
     */
    public function destroy(int | string $id) :RedirectResponse {
        
        $knowledge  = KnowledgeBase::withCount(['childs'])->where('id',$id)->firstOrfail();

        if($knowledge->childs_count > 0){
            return back()->with('error', translate('Fail to delete. please remove all the childrens under this item first.'));
        }

        $knowledge->delete();
        return back()->with('success', translate('Deleted Successfully'));
    }






    /**
     * Undocumented function
     *
     * @param Request $request
     * @return array
     */
    public function changeParent(Request $request) :array {
        
        $request->validate([
            'department_id'  => ['required','exists:departments,id'],
        ]);

        $childs    = $request->input('values',[]);
        $parent_id = $request->input('new_parent') ? $request->input('new_parent') :$request->input('parent_id');

        $knowledge = KnowledgeBase::find($parent_id);


        if(!$knowledge){
            return [
                'status'  => false,
                'message' => translate("Invalid payload"),

            ];
        }
 
        if($request->input('new_parent')){
            $knowledge->parent_id = null;
            $knowledge->save();
        }
        else if (is_array($childs) && count($childs) > 0){
            KnowledgeBase::whereIn('id',$childs)->update([
                'parent_id' => $parent_id
            ]);
        }
 
        $knowledgeDepartment     =  Department::with(['parentKnowledgeBases','parentKnowledgeBases.childs'])
                                             ->find($request->input('department_id'));
        return [
            'status'              => true,
            "hierarchy_html"      => view('admin.knowledgebase.hierarchy', compact('knowledgeDepartment'))->render(),

        ];

       
    }


}
