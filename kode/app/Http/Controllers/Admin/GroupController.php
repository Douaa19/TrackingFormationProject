<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\GroupRequest;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Group;
use App\Models\Priority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
class GroupController extends Controller
{
    
    public function __construct()
    {
        $this->middleware(function($request,$next){

            if(auth_user()->agent == (StatusEnum::true)->status()){
                abort(403,unauthorized_message()); 
            }
            return $next($request);
        });
    }



    
    /**
     * get groups list
     *
     * @return View
     */
    public function index() :View {

        $groups = Group::leftJoin('group_members', 'groups.id', '=', 'group_members.group_id')
        ->leftJoin('admins', 'group_members.agent_id', '=', 'admins.id')
        ->leftJoinSub(DB::table('agent_responses')
            ->select('admins.id as agent_id', DB::raw('AVG(agent_responses.response_time) as avg_response_time'), DB::raw('count(agent_responses.ticket_id) as total_agent_responses'))
            ->join('admins', 'agent_responses.agent_id', '=', 'admins.id')
            ->groupBy('admins.id'), 'agent_avg_response', function ($join) {
                $join->on('admins.id', '=', 'agent_avg_response.agent_id');
            })
        ->join("priorities", "priorities.id", "=", "groups.priority_id")
        ->select('groups.id', 'groups.name', 'groups.status', 'priorities.name as priority', 'priorities.color_code as color_code', DB::raw('AVG(agent_avg_response.avg_response_time) as avg_group_response_time'), DB::raw('COUNT(group_members.agent_id) as agent_count'), DB::raw('SUM(agent_avg_response.total_agent_responses) as total_agent_responses'))
        ->groupBy('groups.id', 'groups.name', 'groups.status', 'priority', 'color_code')
        ->get();
        

        return view('admin.group.index',[

            'groups'     => $groups,
            'title'      => "Manange Groups",
        ]);
    }





    /**
     * create group
     *
     * @return View
     */
    public function create() :View{

        return view('admin.group.create',[

            'priorities' => Priority::active()->latest()->get(),
            'agents'     => Admin::agent()->active()->latest()->get(),
            'categories' => Category::active()
            ->where("ticket_display_flag",StatusEnum::true->status())->get(),
            'title'      => "Create Group",
        ]);
    }





    /**
     * Store A Group
     *
     * @return RedirectResponse
     */
    public function store(GroupRequest $request) :RedirectResponse {



        DB::transaction(function() use ($request) {
            $group               = new Group();
            $group->name         = $request->input('name');
            $group->priority_id  = $request->input('priority');
            $group->status       = StatusEnum::true->status();
            $group->save();
            $group->members()->attach($request->input('agents'));
        });

        return back()->with("success",translate("Group Created Successfully"));

    }


   /**
     * edit a  Group
     *
     * @return View
     */
    public function edit(int|string $id) :View{

        return view('admin.group.edit',[

            'group' => Group::with(['members'])
            ->where('id',$id)
            ->latest()
            ->firstOrFail(),

            'priorities' => Priority::active()->latest()->get(),
            'agents'     => Admin::agent()->active()->latest()->get(),

            'title'      => "Update Group",
        ]);
    }


    /**
     * Update A Priority
     *
     */
    public function update(GroupRequest $request) :RedirectResponse {


        $group                  = Group::with(['members'])
        ->where('id',$request->input("id"))
        ->latest()
        ->firstOrFail();;

        DB::transaction(function() use ($request,$group) {

            $group->name         = $request->input('name');
            $group->priority_id  = $request->input('priority');
            $group->status       = StatusEnum::true->status();
            $group->save();
            $group->members()->detach();
            $group->members()->attach($request->input('agents'));
        });


        return back()->with("success",translate("Group Updated Successfully"));

    }




    /**
     * Update Status
     *
     * @param int $id 
     * @return JsonResponse
     */
    public function statusUpdate(Request $request) :JsonResponse {

        $modelInfo = [
            'table'  => (new Group())->getTable(),
            'key'    => "id",
            'values' => StatusEnum::toArray()
        ];

        validateModelStatus($request,$modelInfo);

        $group                   = Group::where('id',$request->data['id'])->firstOrfail();
        $group->status        = $request->data['status'];
        $group->save();
        $response['status']      = true;
        $response['reload']      = true;
        $response['message']     = translate('Status Updated Successfully');
        return response()->json($response);


        
    }





    /**
     * Destory A group
     *
     * @param int | string $id
     * @return RedirectResponse
     */
    public function destroy(int | string $id) :RedirectResponse {

        $status        = 'success';
        $message       = translate('Group Deleted!!');

        $group         = Group::with(['members'])
        ->where('id',$id)
        ->latest()
        ->firstOrFail();
        $group->members()->detach();
        $group->delete();

        return back()->with($status,$message );

    }


}
