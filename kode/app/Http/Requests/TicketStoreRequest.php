<?php

namespace App\Http\Requests;

use App\Enums\StatusEnum;
use App\Rules\General\FileExtentionCheckRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
class TicketStoreRequest extends FormRequest
{

   
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

    
        $validation  =  $this->get_validation(request()->except(['_token']));
        $rules =  $validation ['rules'];

        if(site_settings('ticket_security') == StatusEnum::true->status()){

            $rules ['default_captcha_code'] = ['required',    function ($attribute, $value, $failed) {

                if (strtolower(request()->default_captcha_code) != strtolower(session()->get('gcaptcha_code'))) {
                    session()->forget('gcaptcha_code');
                    $failed(translate('Captch validation failed'));
                }
            },];
        }

       
        return  $rules;
    }

    public function messages()
    {
     
        $validation  =  $this->get_validation(request()->except(['_token']));

        return $validation ['message'];
    }


    public function get_validation(array $request_data) :array{


        $user = auth_user('web');
        $rules = [];
        $message = [];
        $ticket_fields = json_decode(site_settings('ticket_settings'),true);
        $yes             = StatusEnum::true->status();
        foreach( $ticket_fields as $fields){
            $visibility      = Arr::get($fields , "visibility", null);

            if($fields['required'] == $yes && ($visibility ==  $yes || is_null($visibility))){
                
                if($fields['type'] == 'file'){
                    $rules['ticket_data.'.$fields['name'].".*"] = ['required', new FileExtentionCheckRule(json_decode(site_settings('mime_types'),true),'Ticket File')];
                }
                elseif($fields['type'] == 'email' && !$user){
                    $rules['ticket_data.'.$fields['name']] = ['required','email'];
                    $message['ticket_data.'.$fields['name'].".email"] = ucfirst($fields['name']).translate(' Feild Is Must Be Contain a Valid Email');
                }
                elseif($fields['name'] == 'category'){
                    $rules['ticket_data.'.$fields['name']] = ['required','exists:categories,id'];
                }
                elseif($fields['name'] == 'priority'){
                    $rules['ticket_data.'.$fields['name']] = ['required','exists:priorities,id'];
                }
                else{
                    if($user  && ($fields['name'] == 'name' || $fields['type'] == 'email'))  continue;
                    $rules['ticket_data.'.$fields['name']] = ['required'] ;
                }
                $message['ticket_data.'.$fields['name'].".required"] = ucfirst($fields['name']).translate(' Feild Is Required');
            }
        }
       
        return  [
            'rules' => $rules,
            'message' => $message,
        ] ;
    }
}
