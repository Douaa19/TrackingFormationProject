<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Department;
use App\Models\KnowledgeBase;
use App\Models\Page;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
class FrontendController extends Controller
{


    /**
     * Get Frontend home page view
     *
     * @return View
     */
    public function index() :View {
  
        $title      = "Home";
        $categories = Category::with(['faq'])->active()->get();
        return view('frontend.home' ,compact('title','categories'));
    }


    /**
     * Get All Articles
     *
     * @param Request $request
     * @param string|null $slug
     * @param integer|null $id
     * @return View
     */
    public function articles(Request $request, ? string $slug = null ,? int $id = null) :View{
 
        $item       = Category::where('id',$id)->firstOrFail();
        $categories = ArticleCategory::active()
                            ->withCount(['articles'])
                            ->whereHas("articles" , function($q) use($item){
                                return $q->with(['items'])
                                        ->active()
                                        ->where('category_id',@$item->id)
                                        ->orderBy("serial_id",'ASC');})
                            ->with(['articles'=> function($q) use($item){
                                return $q->with(['items'])
                                            ->active()
                                            ->where('category_id',@$item->id)
                                            ->orderBy("serial_id",'ASC');
                            }])->orderBy("serial_id",'ASC')->get();

        $articleDetails = $categories->first()?->articles->first();
 
        $title          = ucfirst(str_replace("_"," ",$slug));

        return view('frontend.articles' ,compact('title','categories','articleDetails','item'));
    }

    

    /**
     * Get a specific article views
     *
     * @param string $item
     * @param string $category
     * @param string $title
     * @param integer $id
     * @return View
     */
    public function articleView(string $item, string $category,string $title,int $id) :View{

       $articleDetails  = Article::where("id",$id)->firstOrFail();
       $item            = Category::where('id',$articleDetails->category_id)->firstOrFail();

       $title           = str_replace("_"," ",$articleDetails->name);

       $categories      = ArticleCategory::active()
                            ->whereHas("articles" , function($q) use($item){
                                return $q->with(['items'])
                                    ->active()
                                    ->where('category_id',@$item->id)
                                    ->orderBy("serial_id",'ASC');})
                            ->with(['articles'=> function($q) use($item){
                                return $q->with(['items'])
                                    ->active()
                                    ->where('category_id',@$item->id)
                                    ->orderBy("serial_id",'ASC');
                                }])->orderBy("serial_id",'ASC')->get();


       return view('frontend.articles' ,compact('title','categories','articleDetails','item'));
    }



    /**
     * Article Search 
     *
     * @param Request $request
     * @return view | string
     */
    public function articleSearch(Request $request) : view | string  {


        $request->validate([
            "search"          => 'required'
        ],
        [
            "search.required" => translate('Type Something Then Try Again')
        ]);

        $title                = translate("knowledgebase Search");

        $searchTerm           = $request->input('search');

        $likeSearchTerm           = "%".$request->input('search')."%" ;
        $knowledgebases       = KnowledgeBase::whereNotNull('parent_id')->with(['department'])
                                        ->active()
                                        ->where('description',"like", $likeSearchTerm)
                                        ->orWhere('name',"like", $likeSearchTerm)
                                        ->get();


        return  request()->ajax() 
                    ? json_encode([
                            
                        "status"        => true ,
                        "article_html"  => view('frontend.partials.articles', compact('knowledgebases','searchTerm'))->render(),
                    ]) 
                    :view('frontend.article_view' ,compact('title','knowledgebases','searchTerm'));
    }



    /**
     * Get a Sepecific page view
     *
     * @param string $slug
     * @return View
     */
    public function pages(string $slug) :View{

        $page  = Page::active()->where('slug',$slug)->firstOrfail();
        $title = $page->title;
        return view('frontend.pages' ,compact('title','page'));
    }


    /**
     * Store a new subscriber 
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function subscribe(Request $request) :RedirectResponse{

        $request->validate([
            'email'           => 'required|unique:subscribers,email|email',
        ],[
            'email.required'  => translate('Email Is Required'),
            'email.email'     => translate('Enter a valid email'),
            'email.unique'    => translate('Already Subscribed'),
        ]);

        Subscriber::create([
            'email'           => $request->input('email')
        ]);
         
        return back()->with('success',translate('Subscribed Successfully'));
    }




    /**
     * Store a specific contact 
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function contactStore(Request $request) :RedirectResponse{

        $request->validate([
            'email'            =>  'required|email',
            'name'             =>  'required|max:191',
            'subject'          =>  'required|max:191',
            'message'          =>  'required',
    
        ],[
            'email.required'   => translate('Email Is Required'),
            'name.required'    => translate('Name Is Required'),
            'subject.required' => translate('Subject is Required'),
            'message.required' => translate('Message is Required'),
        ]);

        Contact::create([
            'name'             => $request->input('name'),
            'email'            => $request->input('email'),
            'subject'          => $request->input('subject'),
            'message'          => $request->input('message')
        ]);
 
        return back()->with('success',translate('Successfully Contacted'));
    }



  
     /**
      * Knowledgebase view
      *
      * @param string|null $slug
      * @param string|null $knowledge_slug
      * @return View
      */
    public function knowledgebase(? string $slug =  null , ? string $knowledge_slug =  null ) :View{

        $departments    = Department::with(['parentKnowledgeBases'=>function($q){
            return $q->active();
        },'parentKnowledgeBases.childs'=>function($q){
            return $q->active();
        },'knowledgeBases'=>function($q){
            return $q->active();
        }])
                                       ->active()
                                       ->get();

        $knowledge      = KnowledgeBase::with(['department','childs'])
        
                                ->where('slug',$knowledge_slug)
                                ->first();
        
        $title        = translate('Knowledgebase');
        return view('frontend.knowledgebase' ,compact('departments','title','knowledge'));
    }



}
