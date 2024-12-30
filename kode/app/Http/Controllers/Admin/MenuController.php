<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Enums\StatusEnum;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
class MenuController extends Controller
{
    
    /**
     * Menu  List
     *
     * @return View
     */
    public function index() :View {

        return view('admin.menu.index',[
            'title' => "Menu",
            'menus' =>  Menu::orderBy('serial_id')->get()
        ]);
        
    }

    /**
     * Store a Menu
     *
     * @return RedirectResponse
     */
    public function store(Request $request) :RedirectResponse {

        $request->validate([
            'name'               => 'required|unique:menus,name',
            'url'                => 'required',
            'serial_id'          => 'required',
        ],[
            'name.required'      => translate('Name Field Is Required'),
            'name.unique'        => translate('Name Field Must Be Unique'),
            'url.required'       => translate('Menu Url Is Required'),
            'serial_id.required' => translate('Serial Is Required'),
        ]);
 

        Menu::create([
            'name'                =>  $request->name,
            'serial_id'           =>  $request->serial_id,
            'slug'                =>  Str::slug($request->name,'-'),
            'url'                 =>  $request->url,
            'status'              =>  (StatusEnum::true)->status(),
            'show_in_header'      =>  $request->show_in_header ?  $request->show_in_header : (StatusEnum::false)->status() ,
            'show_in_footer'      =>  $request->show_in_footer ?  $request->show_in_footer : (StatusEnum::false)->status(),
            'show_in_quick_link'  =>  $request->show_in_quick_link ?  $request->show_in_quick_link : (StatusEnum::false)->status()
        ]);

        return back()->with('success', translate('Menu Created Successfully'));
    }

 

    /**
     * Update a Menu
     *
     * @return RedirectResponse
     */
    public function update(Request $request) :RedirectResponse {

        $request->validate([

            'id'        =>  'required | exists:menus,id',
            'name'      =>  'required|unique:menus,name,'.$request->id,
            'url'       =>  'required',
            'serial_id' =>  'required',

        ],[
            'id.required'        => translate('Id Field Is Required'),
            'id.exists'          => translate('Invalid Id'),

            'name.required'      => translate('Name Field Is Required'),
            'name.unique'        => translate('Name Field Must Be Unique'),
            'url.required'       => translate('Menu Url Is Required'),
            'serial_id.required' => translate('Serial Is Required'),

        ]);

        
        Menu::where('id',$request->id)->update([

            'name'           => $request->name,
            'serial_id'      => $request->serial_id,
            'slug'           => Str::slug($request->name,'-'),
            'url'            => $request->url,
            'show_in_header' => $request->show_in_header ?  $request->show_in_header : (StatusEnum::false)->status() ,
            'show_in_footer' => $request->show_in_footer ?  $request->show_in_footer : (StatusEnum::false)->status(),
            'show_in_quick_link' => $request->show_in_quick_link ?  $request->show_in_quick_link : (StatusEnum::false)->status()
        ]);

        return back()->with('success', translate('Menu Updated Successfully'));
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
            'table'  => (new Menu())->getTable(),
            'key'    => "id",
            'values' => StatusEnum::toArray()
        ];

        validateModelStatus($request,$modelInfo);
       
        $menu                =  Menu::where('id',$request->data['id'])->first();
        $menu->status        =  $request->data['status'];
        $menu->save();
        $response['status']  =  true;
        $response['reload']  =  true;
        $response['message'] = translate('Status Updated Successfully');

        return response()->json($response);
        
    }

    /**
     * Delete a Menu
     * 
     * @param int $id
     *
     */
    public function destroy(int | string $id) :RedirectResponse {
        
        Menu::where('id',$id)->delete();
        return back()->with('success', translate('Deleted Successfully'));
    }
}
