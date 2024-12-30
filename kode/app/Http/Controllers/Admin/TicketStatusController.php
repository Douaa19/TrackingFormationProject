<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Enums\TicketStatus as EnumsTicketStatus;
use App\Http\Controllers\Controller;
use App\Models\TicketStatus;
use App\Traits\ModelAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class TicketStatusController extends Controller
{
    use ModelAction;



    /**
     * ticket status list
     *
     * @return View
     */
    public function index() :View {

        return view('admin.ticket_status.index',[

            'title'                 => "Ticket Statuses",
            'ticket_statuses'       => TicketStatus::with(['tickets'])->latest()->get()
                                      
        ]);
        
    }


    /**
     * create view of ticket status
     *
     * @return View
     */
    public function create() :View {

        return view('admin.ticket_status.create',[

            'title'          => "Create Ticket Status",
        ]);
        
    }


    /**
     * edit view of ticket status
     *
     * @param  int | string $id 
     * 
     * @return View
     */
    public function edit(int | string $id) :View {

        return view('admin.ticket_status.edit',[
            
            'title'                  => "Update Ticket Status",

            'ticket_status'          => TicketStatus::withoutGlobalScope('autoload')
                                            ->with(['translations'])
                                            ->where("id",$id)->firstOrfail(),
        ]);
        
    }



    /**
     * Store a New Canned Reply
     *
     * @return RedirectResponse
     */
    public function store(Request $request) :RedirectResponse {

        $request->validate([
            'name'              => ['array'],
            "name.*"            => ['max:191'],
            "name.default"      => ["required","unique:ticket_statuses,name,".request()->id],
            "color_code"       => ["required"],
        ],[
            'name.default.required'        =>  translate('Default status field is required'),
            'color_code.required'  =>  translate("Color code  field is required"),
        ]);


        DB::transaction(function() use ($request) {

            $status                   = new TicketStatus();
            $status->name             = Arr::get($request->input('name'),'default','');
            $status->color_code       = $request->input('color_code');
            $status->status           = StatusEnum::true->status();
            $status->default          = StatusEnum::false->status();
            $status->save();
            $this->saveTranslation($status,$request->input('name'),'name');
        });


        return back()->with('success', translate('Status created successfully'));
    }

 

    /**
     * Update a Replay
     *
     * @return RedirectResponse
     */
    public function update(Request $request) :RedirectResponse {

      
        $request->validate([
            'id'                => ['required','exists:ticket_statuses,id'],
            'name'              => ['array'],
            "name.*"            => ['max:191'],
            "name.default"      => ["required","unique:ticket_statuses,name,".request()->id],
            "color_code"        => ["required"],
        ]);


        DB::transaction(function() use ($request) {

            $status                   = TicketStatus::findOrFail($request->input('id'));
            $status->name             = Arr::get($request->input('name'),'default','');
            $status->color_code       = $request->input('color_code');
            $status->status           = StatusEnum::true->status();
            $status->is_base          = StatusEnum::false->status();
            $status->save();
            $this->saveTranslation($status,$request->input('name'),'name');
        });


        return back()->with('success', translate('Status created successfully'));
    }
    

    /**
     * Update Status
     *
     * @param int $id 
     * @return JsonResponse
     */
    public function statusUpdate(Request $request) :JsonResponse {

        $modelInfo = [
            'table'  => (new TicketStatus())->getTable(),
            'key'    => "id",
            'values' => StatusEnum::toArray()
        ];
        
        validateModelStatus($request,$modelInfo);
       
        $status               =  TicketStatus::where('id',$request->data['id'])->first();
        $status->status       =  $request->data['status'];
        $status->save();
        $response['status']   = true;
        $response['reload']   = true;
        $response['message']  = translate('Status Updated Successfully');

        return response()->json($response);
        
    }


    /**
     * Update default status
     *
     * @param int $id 
     * @return JsonResponse
     */
    public function setDefault(Request $request) :JsonResponse {

        $modelInfo = [
            'table'  => (new TicketStatus())->getTable(),
            'key'    => "id",
            'values' => StatusEnum::toArray()
        ];

        validateModelStatus($request,$modelInfo);


        TicketStatus::where('id','!=',$request->data['id'])->update([
           'default'=> (StatusEnum::false)->status()
        ]);

        TicketStatus::where('id',$request->data['id'])->update([
           'default'=>(StatusEnum::true)->status(),
        ]);


        $response['status']          = true;
        $response['reload']          = true;
        $response['message']         = translate('Status Updated Successfully');
        return response()->json($response);


        
    }

    /**
     * Delete a Reply
     * 
     * @param int $id
     *
     */
    public function destroy(int | string $id) :RedirectResponse {

       
        
        $status               =  TicketStatus::withCount(['tickets'])
                                                 ->whereNotIn('id',array_values(EnumsTicketStatus::toArray()))
                                                 ->where('id',$id)->firstOrFail();
 
        if( 0 < $status->tickets_count){
            return back()->with('error', translate('Cannot deleted !! status has tickets under it!!'));
        }

        $status->delete();
        return back()->with('success', translate('Deleted Successfully'));
    }
}
