<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailTemplates;
use Illuminate\Validation\Rule;
use App\Enums\StatusEnum;
class SmsTemplateController extends Controller
{
   
    public function index(): \Illuminate\Contracts\View\View
    {
        $title        = translate("SMS templates");
        $smsTemplates = EmailTemplates::whereNotIn('slug',[
            "TEST_MAIL" ,"REGISTRATION_VERIFY" ,"PASSWORD_RESET_CONFIRM" ,"PASSWORD_RESET" ,"ADMIN_PASSWORD_RESET"
        ])->latest()->paginate(paginateNumber());

        return view('admin.sms_template.index', compact('title', 'smsTemplates'));
    }

    public function edit(int | string $id) :\Illuminate\Contracts\View\View
    {
        $title       = translate("SMS template update");
        $smsTemplate = EmailTemplates::findOrFail($id);
        return view('admin.sms_template.edit', compact('title', 'smsTemplate'));
    }

    public function update(Request $request, int|string $id):\Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'subject'   => ['required','max:255'],
            'status'    => ['required',Rule::in(StatusEnum::toArray())],
            'sms_body'  => ['required']
        ],[
            'subject.required'   => translate('Subject field is required'),
            'status.required'    => translate('Status field is required'),
            'sms_body.required'  => translate('Body field is required'),
        ]);

        $emailTemplate           =  EmailTemplates::findOrFail($id);
        $emailTemplate->subject  =  $request->subject;
        $emailTemplate->status   =  $request->status;
        $emailTemplate->sms_body =  $request->sms_body;
        $emailTemplate->save();

        return back()->with('success',translate('Email template has been updated'));
    }
}
