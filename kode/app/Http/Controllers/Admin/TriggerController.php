<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\TriggerRequest;
use App\Http\Triggers\TriggerConfiguration;
use App\Models\TicketTrigger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class TriggerController extends Controller
{
    
    protected TriggerConfiguration $triggerConfiguration;

    public function __construct(TriggerConfiguration $triggerConfiguration){
        $this->triggerConfiguration = $triggerConfiguration;
    }
    /**
     * get trigger  list
     *
     * @return View
     */
    public function list() :View{

        return view('admin.trigger.list',[
            'triggers'   => TicketTrigger::latest()->get(),
            'title'      => "Manange Triggering",
        ]);
    }


    /**
     * Create a new  trigger
     *
     * @return View
     */
    public function create() :View{


        return view('admin.trigger.create',[
            'title'           => "Create Trigger",
            'trigger_configs' => $this->triggerConfiguration->getTriggerConfig()
        ]);
    }


    /**
     * Store a new Trigger
     *
     * @param TriggerRequest $request
     * @return RedirectResponse
     */
    public function store(TriggerRequest $request) :RedirectResponse {


    

        $trigger                = new TicketTrigger();
        $trigger->name          = $request->input('name');
        $trigger->description   = $request->input('description');
        $trigger->all_condition = $request->input('all',[]);
        $trigger->any_condition = $request->input('any',[]);
        $trigger->actions       = $this->formatAction($request->input("action_values",[]) ,$request->input("actions",[])) ;
        $trigger->status        = StatusEnum::true->status();
        $trigger->save();

        return back()->with("success",translate("Trigger Created Successfully"));

    }


    public function formatAction(array $actions ,array $keys):array{

     

        $formatedActions =  collect($actions)->map(function ($value, $key) {
            return match ($key) {
                'send_sms_to_agent', 'send_email_to_agent', 'send_email_to_user' => $value,
                default => Arr::flatten(array_values($value)),
            };
        })->all();


        $missingKeys = array_diff($keys, array_keys($formatedActions));

        foreach ($missingKeys as $index => $key) {
            $formatedActions[$key][] = $index;
        }

        return $formatedActions;




        
    }


    /**
     * Edit View of a specific  trigger
     *
     * @return View
     */
    public function edit(int|string $id) :View{

        return view('admin.trigger.edit',[

            'trigger'         => TicketTrigger::findOrfail($id),
            'trigger_configs' => $this->triggerConfiguration->getTriggerConfig(),
            'title'           => "Update Trigger",
        ]);
    }



    /**
     * Update  a Specific Trigger
     *
     * @param TriggerRequest $request
     * @return RedirectResponse
     */
    public function update(TriggerRequest $request) :RedirectResponse {

 
        $trigger                = TicketTrigger::findOrfail($request->input('id'));
        $trigger->name          = $request->input('name');
        $trigger->description   = $request->input('description');
        $trigger->all_condition = $request->input('all',[]);
        $trigger->any_condition = $request->input('any',[]);
        $trigger->actions       = $this->formatAction($request->input("action_values",[]),$request->input("actions",[])) ;

        $trigger->status        = StatusEnum::true->status();
        $trigger->save();

        return back()->with("success",translate("Trigger Upated Successfully"));


    }




    /**
     * Update Status
     *
     * @param int $id 
     * @return JsonResponse
     */
    public function statusUpdate(Request $request) :JsonResponse {

        $modelInfo = [
            'table'  => (new TicketTrigger())->getTable(),
            'key'    => "id",
            'values' => StatusEnum::toArray()
        ];

        validateModelStatus($request,$modelInfo);

        $priority                = TicketTrigger::where('id',$request->data['id'])->firstOrfail();
        $priority->status        = $request->data['status'];
        $priority->save();
        $response['status']      = true;
        $response['reload']      = true;
        $response['message']     = translate('Status Updated Successfully');
        return response()->json($response);


        
    }


   
    /**
     * Destory A Trigger
     *
     * @param int | string $id
     * @return RedirectResponse
     */
    public function destroy(int | string $id) :RedirectResponse {


        $trigger      = TicketTrigger::where('id',$id)
                            ->latest()
                            ->firstOrFail();
        $trigger->delete();

        return back()->with('success',translate('Trigger Deleted!!'));

    }


    /**
     * Add Trigger Condition
     *
     * @return array
     */
    public function addCondition(Request $request) :array {

        $request->validate([
            'type'      =>['required',Rule::in(['all','any','actions'])] ,

        ]);

        return ([

            "html" => view('admin.trigger.condition', [
                'trigger_configs' => $this->triggerConfiguration->getTriggerConfig(),
                'type'            => $request->input('type'),
            ])->render(),
        ]);
    }

}
