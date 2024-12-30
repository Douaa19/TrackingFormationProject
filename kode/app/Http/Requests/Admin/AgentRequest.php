<?php

namespace App\Http\Requests\Admin;

use App\Rules\General\FileExtentionCheckRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class AgentRequest extends FormRequest
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

        return [
            
            'name'        => "required",
            'email'       => "required | unique:admins,email,".request()->id,
            'username'    => "required | unique:admins,username,".request()->id,
            'phone'       => "required",
            'type'        => "required|in:1,0",
            'password'    => [Rule::requiredIf(!request()->id),'confirmed','min:5'],
            'categories'  => 'nullable|array',
            'permissions' => 'nullable|array',
            'address'     =>  Rule::requiredIf(site_settings("auto_ticket_assignment") == '1' && site_settings('geo_location') == 'map_base'),
            'image'=>['image',new FileExtentionCheckRule(json_decode(site_settings('mime_types'),true))]
        ];
    }

    public function messages()
    {
        return [
            'name.required'          => translate("Name Field Is Required"),
            'email.required'         => translate("Email Field is Required"),
            'email.unique'           => translate("This email is already taken"),
            'username.required'      => translate("User Name Field Is Required"),
            'username.unique'        => translate("This username is already taken"),
            'phone.required'         => translate("Phone Field Is Required"),
            'categories.required'    => translate('Please Select a Category'),
            'permissions.required'   => translate('Permission Is Required'),
            'status.required'        => translate('Please Select An Status'),
            'password.required'      => translate('Password Feild Is Required'),
            'password.confirmed'     => translate('Confirm Password Does not Match'),
            'password.min'           => translate('Minimum 5 digit or character is required'),
            'address.required'       => translate('Select Your Address'),
        ];
    }
}
