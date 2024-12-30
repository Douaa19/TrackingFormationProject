<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailTemplates;
use Illuminate\Validation\Rule;
use App\Enums\StatusEnum;
class EmailTemplateController extends Controller
{
    /**
     * Display the email tempaltes.
     *
     */
    public function index() : \Illuminate\Contracts\View\View
    {
        $title          = translate("Email templates");
        $emailTemplates = EmailTemplates::latest()->paginate(paginateNumber());
        return view('admin.email_template.index', compact('title', 'emailTemplates'));
    }


    /**
     * edit a mail tempates
     *
     * @param int|string $id
     */
    public function edit(int | string $id)  : \Illuminate\Contracts\View\View
    {
        $title           = translate("Update templates");
        $emailTemplate   = EmailTemplates::where('id', $id)->first();
        return view('admin.email_template.edit', compact('title', 'emailTemplate'));
    }



    /**
     * Update an email template.
     *
     * @param  $request
     * @param  int|string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
   public function update(Request $request, int|string $id):\Illuminate\Http\RedirectResponse
   {
        $this->validate($request, [
            
            'subject'   => ['required','max:255'],
            'status'    => ['required',Rule::in(StatusEnum::toArray())],
            'body'       => ['required']
        ],
        [
            'subject.required'  => translate('Subject field is required'),
            'status.required'   => translate('Status field is required'),
            'body.required'     => translate('Body field is required'),
        ]);

        $emailTemplate          = EmailTemplates::findOrFail($id);
        $emailTemplate->subject = $request->subject;
        $emailTemplate->status  = $request->status;
        $emailTemplate->body    = $request->body;
        $emailTemplate->save();
        
        return back()->with('success', translate('Email template has been updated'));
   }
}
