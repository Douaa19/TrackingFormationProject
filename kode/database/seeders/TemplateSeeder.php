<?php

namespace Database\Seeders;

use App\Models\EmailTemplates;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $templates  = [

            "SUPPORT_TICKET_AUTO_CLOSED" => [
                'name'    => 'Ticket Closed',
                'subject' => 'Ticket Closed',
                'body' => '<p>Your ticket is closed as we received no response from you  Ticket ID {{ticket_number}},&nbsp;<br>kindly click the link provided below in order to view the ticket. <a style="background-color:#13C56B;border-radius:4px;color:#fff;display:inline-flex;font-weight:400;line-height:1;padding:5px 10px;text-align:center:font-size:14px;text-decoration:none;" href="{{link}}">Link</a></p>',
                'sms_body' => 'Your Ticket Closed',
                'codes' => [
                    'ticket_number' => 'Ticket Number',
                    'link'          => 'Ticket Link',
                ]
                ],

                "TICKET_ACCESS_CODE" => [
                    'name'    => 'Ticket Access Code',
                    'subject' => 'Your Ticket Access Code',
                    'body' => 'Your access code: {{code}} Use it to find your ticket.',
                    'sms_body' => 'Your access code: {{code}} Use it to find your ticket.',
                    'codes' => [
                        'code' => 'OTP Code',
                    ]
                ]

        ];


        $existingTemplates = EmailTemplates::pluck('slug')->toArray();


        foreach ($templates as $templateKey => $data) {

            if(!in_array($templateKey , $existingTemplates )){
                $template           = EmailTemplates::firstOrNew(['slug' => $templateKey]);
                $template->name     = Arr::get($data,'name');
                $template->subject  = Arr::get($data,'subject');
                $template->body     = Arr::get($data,'body');
                $template->sms_body = Arr::get($data,'sms_body');
                $template->codes    = Arr::get($data,'codes');
                $template->save();
            }
        }
        
    }
}
