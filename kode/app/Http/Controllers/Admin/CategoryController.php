<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
class CategoryController extends Controller
{
    
    /**
     * Category List
     *
     * @return View
     */
    public function index(Request $request) :View {

        return view('admin.category.index',[

            'title'       => "Categories",
            'categories'  => Category::where("ticket_display_flag",StatusEnum::true->status())
            ->filter($request)
            ->latest()
            ->paginate(paginateNumber())
            ->appends($request->all())
        ]);
    }

    /**
     * Store a New Category
     *
     * @param CategoryRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryRequest $request) :RedirectResponse {

        $image = null;

        if($request->hasFile('image')){

            try{
                $image = storeImage($request->file('image'), getFilePaths()['category']['path'], null);
            }catch (\Exception $exp){
                return back()->with('error', translate("Unable to upload file. Check directory permissions"));
            }
        }

        $category = Category::create([
            'name'                  => json_encode($request->name),
            'image'                 => $image,
            'sort_details'          => ($request->sort_details),
            'status'                => (StatusEnum::true)->status(),
            'article_display_flag'  => $request->article_display_flag ?  $request->article_display_flag : StatusEnum::false->status(),
            'ticket_display_flag'   => $request->ticket_display_flag ? $request->ticket_display_flag : $request->ticket_display_flag 
        ]);

        return back()->with('success', translate('Category Created Successfully'));
    }


    /**
     * article create view
     *
     * @return View
     */
    public function article($id) :View {

        $latestArticle =  Article::where('category_id',$id)
        ->orderBy("serial_id",'desc')
        ->first();

        return view('admin.article.create',[

            'title'       => "Articles Create",
            'categories'  =>  ArticleCategory::active()->orderBy("serial_id",'ASC')->get(),
            'items'       =>  Category::active()->latest()->get(),
            'serial_id'   =>  $latestArticle? (int)$latestArticle->serial_id+1 :1,
            
        ]);
        
    }
    /**
     * article create view
     *
     * @return View
     */
    public function show($id) :View {
    

        return view('admin.article.index',[

            'title'      => "Articles",
            'articles'   =>  Article::with(['items','category'])
            ->where("category_id",$id)
            ->latest()
            ->paginate(paginateNumber()),

            'category'   => Category::where('id',$id)->first()
        ]);
        
    }

    public function edit(int $id) :View{
        
        return view('admin.category.edit',[
            'title'    => "Update Category",
            'category' => Category::where('id',$id)->first()
        ]);
    }

    /**
     * Store a New Category
     *
     * @param CategoryRequest $request
     * @return RedirectResponse
     */
    public function update(CategoryRequest $request) :RedirectResponse {

        
        $category          = Category::where('id',$request->id)->first();
        $image             =  $category->image;
        if($request->hasFile('image')){
            $removeFile    = $category->image;
            try{
                $image     = storeImage($request->file('image'), getFilePaths()['category']['path'], null ,$removeFile);
            }catch (\Exception $exp){
                return back()->with('error', translate("Unable to upload file. Check directory permissions"));
            }
        }
        $category->name                  = json_encode($request->name);
        $category->sort_details          = ($request->sort_details);
        $category->image                 = $image ;
        $category->article_display_flag  = $request->article_display_flag;
        $category->ticket_display_flag   = $request->ticket_display_flag ;
        $category->save();
        
        return back()->with('success', translate('Category Updated Successfully'));
    }
    

    /**
     * Update A category Status
     *
     * @param int $id 
     * @param Enum $status
     * @return JsonResponse
     */
    public function statusUpdate(Request $request) :JsonResponse {

        $modelInfo = [
            'table'  => (new Category())->getTable(),
            'key'    => "id",
            'values' => StatusEnum::toArray()
        ];
        validateModelStatus($request,$modelInfo);
       
        $category              =  Category::where('id',$request->data['id'])->firstOrfail();
        $category->status      = $request->data['status'];
        $category->save();
        $response['status']    = true;
        $response['reload']    = true;
        $response['message']   = translate('Status Updated Successfully');

        return response()->json($response);
        
    }

    /**
     * Delete a New category
     * 
     * @param int $id
     *
     */
    public function destroy(int | string $id) :RedirectResponse {

     
        $category      =  Category::withCount(['articles','faq','tickets'])->where('id',$id)->firstOrfail();
        $response      =  $this->delete($category);

        return back()->with(Arr::get($response,'status','error'),Arr::get($response,'message','error'));
    }


    /**
     * Delete A Specific category
     *
     * @param Category $category
     * @return array
     */
    public function delete(Category $category) :array{

        $status        = 'error';
        $message       = translate('Can Not Deleted!! This Category Has lot Of item');

        if($category->faq_count == 0 && $category->tickets_count == 0 && $category->articles_count == 0){

            $status    = 'success';
            $message   = translate('Category Deleted!!');
            if($category->image){
                remove_file(getFilePaths()['category']['path'], $category->image);
            }
            $category->delete();
        }

        return [
            'status'  => $status ,
            'message' => $message 
        ];
    }
    

    /**
     * Bulk Action Method
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function bulkAction(Request $request) : RedirectResponse {

    
        $bulkIds         = json_decode($request->input('bulk_id'), true);

        $request->merge([
            "bulk_id"    => $bulkIds 
        ]);

        $rules = [
            'bulk_id'    => ['array', 'required'],
            'bulk_id.*'  => ['exists:categories,id'],
            'type'       => ['required', Rule::in(['status', 'delete'])],
            'value'      => [
                Rule::requiredIf(function () use ($request) {
                    return $request->input('type') === 'status';
                }),
        
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('type') === 'status' && !in_array($value, StatusEnum::toArray())) {
                        $fail("The {$attribute} is invalid.");
                    }
                },
            ],
        ];

        $request->validate($rules);


        $message   =  translate('Successfully updated categories status');
        $bulkIds   = $request->get('bulk_id');
        if($request->get("type") == 'status'){

            Category::whereIn('id',$bulkIds)->update([
                "status" => $request->get('value')
            ]);
        }
        else {
            
            $message     =  translate('Categories with no associated items have been successfully deleted.');

            $categories  = Category::withCount(['articles','faq','tickets'])
            ->whereIn('id',$bulkIds)
            ->get();

            foreach($categories->chunk(paginateNumber()) as $categoryChunks){

                foreach($categoryChunks as $category){

                    $this->delete($category);
                }

            }
          
        }
    

        return  back()->with('success',$message);
        
    }
    
}
