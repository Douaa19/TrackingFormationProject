<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
class ArticleController extends Controller
{
    


    /**
     * article 
     *
     * @return View
     */
    public function index(Request $request) :View {

        return view('admin.article.index',[
            'title'     => "Articles",
            'articles'  =>  Article::with(['items','category'])
            ->filter($request)
            ->latest()
            ->paginate(paginateNumber())
            ->appends($request->all())
        ]);
        
    }

    /**
     * article create view
     *
     * @return View
     */
    public function create() :View {

        $latestArticle =  Article::orderBy("serial_id",'desc')->first();

        return view('admin.article.create',[

            'title'       => "Articles Create",
            'categories'  => ArticleCategory::active()
            ->orderBy("serial_id",'ASC')
            ->get(),
            'items'       => Category::active()->where('article_display_flag',StatusEnum::true->status())
            ->latest()
            ->get(),
            'serial_id'   =>   $latestArticle? (int)$latestArticle->serial_id + 1 :1,
        ]);
        
    }

    /**
     * article edit view
     *
     * @return View
     */
    public function edit(string |int $id) :View {

        return view('admin.article.edit',[

            'title'      => "Articles Update",
            'categories' => ArticleCategory::active()->orderBy("serial_id",'ASC')->get(),
            'items'      => Category::active()->latest()->get(),
            'article'    => Article::where('id',$id)->first()
        ]);
        
    }

    /**
     * Store Article 
     *
     * @return RedirectResponse
     */
    public function storeArticle(Request $request) :RedirectResponse {

        $request->validate([

            'name'                => 'required',
            'serial_id'           => 'required',
            'description'         => 'required',
            'category_id'         => 'required||exists:categories,id',
            'article_category_id' => 'required|exists:article_categories,id',
         
        ],[
            'name.required'                => translate('Name Field Is Required'),
            'serial_id.required'           => translate('Serial Id Required'),
            'description.required'         => translate('Name Field Is Required'),
            'category_id.required'         => translate('Category Feild Is Required'),
            'article_category_id.required' => translate('Article Category Field Is Required'),
        ]);

        Article::create([

            'name'                 => $request->name,
            'serial_id'            => $request->serial_id,
            'category_id'          => $request->category_id,
            'article_category_id'  => $request->article_category_id,
            'description'          => $request->description,
            'status'               => (StatusEnum::true)->status()
        ]);

        return back()->with('success', translate('Article Created Successfully'));
    }

 

    /**
     * Update a Article Category
     *
     * @return RedirectResponse
     */
    public function updateArticle(Request $request) :RedirectResponse {
       
        $request->validate([
            'name'                   => 'required',
            'description'            => 'required',
            'serial_id'              => 'required',
            'category_id'            => 'required||exists:categories,id',
            'article_category_id'    => 'required|exists:article_categories,id',
         
        ],[
            'name.required'          => translate('Name Field Is Required'),
            'serial_id.required'     => translate('Serial Id Required'),
            'description.required'   => translate('Name Field Is Required'),

        ]);

        Article::where('id',$request->id)->update([

            'name'                   => $request->name,
            'serial_id'              => $request->serial_id,
            'category_id'            => $request->category_id,
            'article_category_id'    => $request->article_category_id,
            'description'            => $request->description,
        ]);

        return back()->with('success', translate('Category Updated Successfully'));
    }


    /**
     * Update Status
     *
     * @param int $id 
     * @param Enum $status
     * @return JsonResponse
     */
    public function articleStatusUpdate(Request $request) :JsonResponse {

        $modelInfo = [
            'table'  => (new Article())->getTable(),
            'key'    => "id",
            'values' => StatusEnum::toArray()
        ];
        validateModelStatus($request,$modelInfo);
       
        $category             =  Article::where('id',$request->data['id'])->first();
        $category->status     =  $request->data['status'];
        $category->save();
        $response['status']   = true;
        $response['reload']   = true;
        $response['message']  = translate('Status Updated Successfully');

        return response()->json($response);
        
    }

    /**
     * Delete a article
     * 
     * @param int $id
     *
     */
    public function destroyArticle(int | string $id) :RedirectResponse {

        $article    = Article::where('id',$id)->firstOrfail();
        $status     = 'success';
        $message    = translate('Article Deleted!!');
        $article->delete();
        return back()->with($status ,$message);
    }



    
    /** article category sections start */



    public function category(Request $request) :View {

        return view('admin.category.index',[

            'title'       => "Article Topics",
            'categories'  => Category::filter($request)->where("article_display_flag",StatusEnum::true->status())
            ->latest()
            ->paginate(paginateNumber())
            ->appends($request->all())
        ]);
        
    }



    public function categoryEdit(int $id) :View{
        
        return view('admin.category.edit',[
            'title'    => "Update Topics",
            'category' => Category::where('id',$id)->first()
        ]);
    }

    
    /**
     * article category
     *
     * @return View
     */
    public function subCategory(Request $request) :View {

        $latestCategory   =  ArticleCategory::orderBy("serial_id",'desc')->first();

        return view('admin.article.category',[

            'title'       =>  "Article Categories",
            'categories'  =>  ArticleCategory::filter($request)->orderBy("serial_id",'ASC')->paginate(paginateNumber()),
            'serial_id'   =>  $latestCategory ? (int)$latestCategory->serial_id+1: 1
        ]);
        
    }

    /**
     * Store Article category
     *
     * @return RedirectResponse
     */
    public function store(Request $request) :RedirectResponse {

        $request->validate([

            'name'       => 'required|unique:article_categories,name',
            'serial_id'  => 'required',
         
        ],[
            'name.required'      => translate('Name Field Is Required'),
            'serial_id.required' => translate('Serial Is Required'),
            'name.unique'        => translate('Name Field Must Be Unique')
        ]);

        ArticleCategory::create([

            'name'       => $request->name,
            'serial_id'  => $request->serial_id,
            'slug'       => make_slug($request->name),
            'status'     => (StatusEnum::true)->status()
        ]);

        return back()->with('success', translate('Article Category Created Successfully'));
    }

 

    /**
     * Update a Article Category
     *
     * @return RedirectResponse
     */
    public function update(Request $request) :RedirectResponse {

        $request->validate([
            
            'id'           => 'required | exists:article_categories,id',
            'name'         => 'required|unique:article_categories,name,'.$request->id,
            'serial_id'    => 'required',

        ],[
            
            'id.required'        => translate('Id Field Is Required'),
            'serial_id.required' => translate('Serial Is Required'),
            'id.exists'          => translate('Invalid Id'),
            'name.required'      => translate('Name Field Is Required'),
            'name.unique'        => translate('Name Field Must Be Unique')
        ]);

        ArticleCategory::where('id',$request->id)->update([

            'name'      => $request->name,
            'serial_id' => $request->serial_id,
            'slug'      => make_slug($request->name),

        ]);

        return back()->with('success', translate('Category Updated Successfully'));
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
            'table'  => (new ArticleCategory())->getTable(),
            'key'    => "id",
            'values' => StatusEnum::toArray()
        ];
        validateModelStatus($request,$modelInfo);
       
        $category            =  ArticleCategory::where('id',$request->data['id'])->first();
        $category->status    = $request->data['status'];
        $category->save();
        $response['status']  = true;
        $response['reload']  = true;
        $response['message'] = translate('Status Updated Successfully');
        return response()->json($response);
        
    }

    /**
     * Delete a article Category
     * 
     * @param int $id
     *
     */
    public function destroy(int | string $id) :RedirectResponse {
        
        $category       = ArticleCategory::withCount(['articles'])->where('id',$id)->firstOrfail();

        $response      =  $this->delete($category);

        return back()->with(Arr::get($response,'status','error'),Arr::get($response,'message','error'));
    }



    

    /**
     * delete a article category
     *
     * @param ArticleCategory $category
     * @return array
     */
    public function delete(ArticleCategory $category) :array {

        $status        = 'error';
        $message       = translate('Can Not Deleted!! This Category Has lot Of item');

           
        if($category->articles_count == 0){
            $status     = 'success';
            $message    = translate('Category Deleted!!');
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
            'bulk_id.*'  => ['exists:articles,id'],
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


        $message   =  translate('Successfully updated Articles status');
        $bulkIds   = $request->get('bulk_id');
        if($request->get("type") == 'status'){

            Article::whereIn('id',$bulkIds)->update([
                "status" => $request->get('value')
            ]);
        }
        else {
            $message     =  translate('Articles with no associated items have been successfully deleted.');
            Article::whereIn('id',$bulkIds)
            ->delete();
        }
    

        return  back()->with('success',$message);
        
    }



    /**
     * Bulk Action Method
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function bulkCategoryAction(Request $request) : RedirectResponse {


        $bulkIds         = json_decode($request->input('bulk_id'), true);

        $request->merge([
            "bulk_id"    => $bulkIds 
        ]);

        $rules = [
            'bulk_id'    => ['array', 'required'],
            'bulk_id.*'  => ['exists:article_categories,id'],
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

            ArticleCategory::whereIn('id',$bulkIds)->update([
                "status" => $request->get('value')
            ]);
        }
        else {
            $message     =  translate('Categories with no associated items have been successfully deleted.');
            $categories  =  ArticleCategory::withCount(['articles'])->whereIn('id',$bulkIds)
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
