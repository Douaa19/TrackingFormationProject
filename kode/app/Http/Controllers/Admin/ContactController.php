<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utility\SendMail;
use App\Jobs\SendSmsJob;
use App\Models\Contact;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    

    
    /**
     * subscriber List
     *
     * @return View
     */
    public function subscriber() :View {

        return view('admin.contact.subscriber',[
            'title'        => "Subscribers",
            'subscribers'  => Subscriber::latest()->get()
        ]);
        
    }

    /**
     * Contact List
     *
     */
    public function index() :View {

        return view('admin.contact.index',[
            'title'    => "Contact List",
            'contacts' => Contact::latest()->get()
        ]);
    }

    public function sendMail(Request $request) :RedirectResponse{


        if($request->all_subscribers && $request->all_subscribers == 'subscribers' ){

            $this->subscriberMail($request);
        }
        else{

            $request->validate([
                'message'  => 'required',
                'email'    => 'email|required',
            ],[
                'message.required' => translate('Message Is  Required'),
                'email.required'   => translate('Email Required'),
            ]);
    
             $mailCode =[
                'name'     =>  $request->email,
                'email'    =>  $request->email,
                "message"  =>  $request->message
             ];
    
            SendMail::MailNotification((object)$mailCode,"contact_reply", $mailCode);

        }


        return back()->with('success', translate('Succesfully Sent'));
    }

    public function subscriberMail($request){


        $subscribers = Subscriber::latest()->get();


        foreach( $subscribers as $subscriber){
 
            $templateCode = [

                'name'     => $subscriber->email,
                'email'    => $subscriber->email,
                "message"  => $request->message

            ];
 
            SendSmsJob::dispatch((object) $templateCode,'contact_reply',$templateCode);
 
        }
     

    }


    /**
     * Delete a subscriber
     * 
     * @param int $id
     *
     */
    public function destroy(int | string $id) :RedirectResponse {

        Subscriber::where('id',$id)->delete();

        return back()->with('success', translate('Deleted Successfully'));
    }

   /**
     * Delete a contact
     * 
     * @param int $id
     *
     */
    public function deleteContact(int | string $id) :RedirectResponse {
        
        Contact::where('id',$id)->delete();
        return back()->with('success', translate('Deleted Successfully'));
    }

}
