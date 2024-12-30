<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\ReponseFormat;
class PriorityRequest extends FormRequest
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

        $keys = [
            "response",
            "resolve"  
        ];

        if(request()->routeIs('admin.priority.update')){

            $rules ['id']       = ['required','exists:priorities,id'];
        }
  
        $rules ['name']         = ['required' ,"max:100",'unique:priorities,name,'.request()->id];
        $rules ['color_code']   = ['required' ,"max:100"];
  
        foreach($keys as $key){

            $rules[$key]                = ['required' , 'array'];
            $rules[$key.".in"]          = ['required','numeric','gt:0','max:200'];
            $rules[$key.".format"]      = ['required',Rule::in(ReponseFormat::toArray())];

        }

        return $rules;
    }
}
