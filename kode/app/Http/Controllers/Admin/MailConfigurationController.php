<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Utility\SendMail;
use App\Models\Department;
use App\Models\EmailTemplates;
use App\Models\IncommingMailGateway;
use Illuminate\Http\Request;
use App\Models\MailConfiguration;
use App\Models\Settings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class MailConfigurationController extends Controller
{
  
    public function index() :View
    {
        $title = translate("Mail Configuration");
        $mails = MailConfiguration::latest()->paginate(paginateNumber());
        return view('admin.mail.index', compact('title', 'mails'));
    }

    public function edit(int | string $id) :View
    {
        $title   = translate("Update Gateway");
        $mail    = MailConfiguration::where('id', $id)->first();
        return view('admin.mail.edit', compact('title', 'mail'));
    }

    public function mailUpdate(Request $request, int | string $id) :RedirectResponse
    {
        $this->validate($request, [
            'driver'       => "required_if:name,==,smtp",
            'host'         => "required_if:name,==,smtp",
            'port'         => "required_if:name,==,smtp", 
            'encryption'   => "required_if:name,==,smtp",
            'username'     => "required_if:name,==,smtp",
            'password'     => "required_if:name,==,smtp",
            'from_address' => "required_if:name,==,smtp",
            'from_name'    => "required_if:name,==,smtp",
        ]);
        $mail = MailConfiguration::where('id', $id)->first();

        if($mail->name == "SMTP"){
            $mail->driver_information = [
                'driver'     => $request->driver,
                'host'       => $request->host,
                'port'       => $request->port,
                'from'       => array('address' => $request->from_address, 'name' => $request->from_name),
                'encryption' => $request->encryption,
                'username'   => $request->username,
                'password'   => $request->password,
            ];
        }elseif($mail->name == "SendGrid Api"){
            $mail->driver_information = [
                'app_key' => $request->app_key,
                'from'    => [
                    'address' => $request->input('from_address'),
                    'name'    => $request->input('from_name')
                ],
            ];
        }
        $mail->save();
     
        return back()->with('success',translate(ucfirst($mail->name).' mail method has been updated'));
        
    }

    public function incoming() :View {

        $title = translate("Incoming Mail Configuration");
        $gateways =  IncommingMailGateway::with("product")->latest()->get();
        $departments =  Department::active()->latest()->get();
        return view('admin.mail.incoming', compact('title','gateways','departments'));
    }


    public function incomingEdit(int $id ) :View {

        $title    = translate("Incoming Method Create");
        $gateways =  IncommingMailGateway::with("product")->latest()->get();
        $gateway  =  IncommingMailGateway ::findOrfail($id);
        $departments =  Department::active()->latest()->get();
        return view('admin.mail.incoming', compact('title','gateways','departments','gateway'));
    }
    public function incomingStore(Request $request , ? int $id = null) :RedirectResponse {


        $request->validate([
            'name'          => "required|max:191|unique:incomming_mail_gateways,name,".$id,
            'department_id' => "nullable|int|exists:departments,id",
            'credentials'   => "required|array",
            'credentials.*' => "required|string",
            'match_keywords'=> "required|array",
        ]);
    
        
        $incommingMailGateway  = $id ? IncommingMailGateway ::findOrfail($id) : new IncommingMailGateway();

        $incommingMailGateway->name            = $request->input('name');
        $incommingMailGateway->department_id   = $request->input('department_id');
        $incommingMailGateway->credentials     = $request->input('credentials');
        $incommingMailGateway->match_keywords  = $request->input('match_keywords');
        $incommingMailGateway->save();


        return back()->with('success',translate($id ?  "Gateway updated succesfully" :"Gateway created succesfully"));

    }

     /**
     * Update Status
     *
     * @param int $id 
     * @return JsonResponse
     */
    public function statusUpdate(Request $request) :JsonResponse {

        $modelInfo = [
            'table'  => (new IncommingMailGateway())->getTable(),
            'key'    => "id",
            'values' => StatusEnum::toArray()
        ];

        validateModelStatus($request,$modelInfo);

        $gateway                   = IncommingMailGateway::where('id',$request->data['id'])->firstOrfail();
        $gateway->status           = $request->data['status'];
        $gateway->save();


        $response['status']      = true;
        $response['reload']      = true;
        $response['message']     = translate('Status Updated Successfully');
        return response()->json($response);


    }


    public function incomingUpdate(Request $request) :string
    {
        $this->validate($request, [
            'host'         => "required",
            'port'         => "required", 
            'encryption'   => "required",
            'username'     => "required",
            'password'     => "required",
            'protocol'     => "required",
        ]);

        Settings::updateOrInsert(
            ['key'    => 'imip'],
            ['value'  => json_encode($request->except(['_token','email_keywords']))]
        );
        Settings::updateOrInsert(
            ['key'    => 'email_keywords'],
            ['value'  => json_encode($request->input('email_keywords',[]))]
        );
        optimize_clear();
        return json_encode([
            'status'  =>  true,
            'message' => translate('Setting has been updated')
        ]);
       

        
    }


     /**
     * Delete a gateway
     * 
     * @param int $id
     *
     */
    public function destroy(int | string $id) :RedirectResponse {
        
        $gateway               =  IncommingMailGateway::where('id',$id)->firstOrFail();
        $gateway->delete();

        return redirect()->route('admin.mail.incoming')->with('success', translate('Deleted Successfully'));
    }

    public function sendMailMethod(Request $request) :RedirectResponse
    {
        $this->validate($request, [
            'id' => 'required|exists:mails,id'
        ]);
        $mail          = MailConfiguration::where('id',$request->id)->first();
        $site_settings = Settings::where('key','email_gateway_id')->update([
            'value'    => $mail->id
        ]);
        optimize_clear();

        return back()->with('success',translate('Email method has been updated'));
    }

    public function globalTemplate() :View
    {
        $title = translate("Global template");
        return view('admin.mail.global_template', compact('title'));
    }


    public function testGateway(Request $request) :RedirectResponse
    {

        $request->validate([
            'email' => 'required|email',
            'id'    => 'required',
        ]);

        $status             = 'error';
        $message            = translate("Mail Configuration Error, Please check your mail configuration properly");
        $mailConfiguration  = MailConfiguration::where('id', $request->id)->first();
        $emailTemplate      = EmailTemplates::where('slug', 'TEST_MAIL')->first();
        $messages           = str_replace("{{name}}", @site_settings('site_name'), $emailTemplate->body);
        $messages           = str_replace("{{time}}", @Carbon::now(), $messages);

        if($mailConfiguration->name === "PHP MAIL"){

            $response = SendMail::sendPHPMail( site_settings('email'), site_settings('site_name'), $request->input('email'), $emailTemplate->subject, $messages);
        }
        elseif($mailConfiguration->name === "SMTP"){

            $response = SendMail::sendSMTPMail($mailConfiguration->driver_information->from->address, $request->input('email'), site_settings('site_name'), $emailTemplate->subject, $messages);
        }
        elseif($mailConfiguration->name === "SendGrid Api"){

            $response = SendMail::sendGrid( $mailConfiguration->driver_information->from->address, site_settings('site_name'), $request->input('email'), $emailTemplate->subject, $messages, @$mailConfiguration->driver_information->app_key);
        }
        if($response){

            $status = 'success';
            $message = translate("Successfully Sent Mail, please check your inbox or spam");
        }

        return back()->with( $status, $message);
    }

  
}
