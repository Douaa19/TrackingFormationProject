<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
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

        $rules ['name']         = ['required' ,"max:100",'unique:groups,name,'.request()->id];
        $rules ['priority']     = ['required' ,"unique:groups,priority_id",'exists:priorities,id'];
        $rules ['agents']       = ['required' ,'array'];
        $rules ['agents.*']     = ['required' ,'exists:admins,id'];

        if(request()->routeIs('admin.group.update')){

            $rules ['id']       = ['required','exists:groups,id'];
        }
  
  
        return $rules ;
    }
  
    public function messages()
    {
     
        return [
            "priority.unique" => "This priority is already taken",
            "name.unique"     => "This name is already taken",
        ];
    }
}
