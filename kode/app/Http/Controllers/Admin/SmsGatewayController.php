<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmsGateway;
use App\Models\Settings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use App\Enums\StatusEnum;
use Illuminate\Validation\Rule;
class SmsGatewayController extends Controller
{
    

    public function index() :View
    {
    	$title       = translate("Sms Gateway list");
    	$smsGateways = SmsGateway::latest()->paginate(paginateNumber());
    	return view('admin.sms_gateway.index', compact('title', 'smsGateways'));
    }

    public function edit(int | string $id) :View
    {
        $title      = translate("Sms Gateway update");
    	$smsGateway = SmsGateway::findOrFail($id);
    	return view('admin.sms_gateway.edit', compact('title', 'smsGateway'));
    }

    public function update(Request $request, int | string $id) :RedirectResponse
    {
    	$this->validate($request, [
            'status' => ['required',Rule::in(StatusEnum::toArray())],
        ]);

    	$smsGateway  = SmsGateway::findOrFail($id);
    	$parameter   = [];
        foreach ($smsGateway->credential as $key => $value) {
            $parameter[$key]    = $request->sms_method[$key];
        }
        $smsGateway->credential = $parameter;
        $smsGateway->status     = $request->status;
        $smsGateway->save();

        return back()->with('success',translate('Sms Gateway has been updated'));
    }

    public function defaultGateway(Request $request) :RedirectResponse
    {
    	$smsGateway    = SmsGateway::findOrFail($request->id);
        $site_settings = Settings::where('key','sms_gateway_id')->update([
            'value'    => $smsGateway->id
        ]);
        optimize_clear();
        return back()->with('success',translate('Default Sms Gateway has been updated'));
    }

    public function globalSMSTemplate() :View
    {
        $title = "SMS Global template";
        return view('admin.sms_gateway.global_template', compact('title'));
    }

  
}