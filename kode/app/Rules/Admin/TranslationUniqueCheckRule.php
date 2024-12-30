<?php

namespace App\Rules\Admin;

use Illuminate\Contracts\Validation\Rule;

class TranslationUniqueCheckRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $id,$model,$column,$title,$lang_code ,$message = '';
    public function __construct($model,$column, $id = null ,$lang_code =  null)
    {
        $this->id = $id;
        $this->column = $column;
        $this->model = $model;
        $this->lang_code = $lang_code;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(!isset($value[session()->get("locale")])){
            $this->message = translate('Name '.ucfirst(session()->get("locale")).' Must e Required');
            return false;
        }
        $flag = 1;
        $translation_data = app(config('constants.options.model_namespace').$this->model)::latest()->pluck($this->column)->toArray();
        if($this->id){
            $translation_data  = app(config('constants.options.model_namespace').$this->model)::latest()->where('id','!=',$this->id)->pluck($this->column)->toArray();
        }

        foreach($translation_data as $data){
            foreach(system_language() as $language){
                $lang_data = json_decode($data,true);
                if(isset($lang_data[$language->code]) && $value[$language->code]){
                    if ($lang_data[$language->code] == $value[$language->code]){
                        $flag = 0;
                        break 2;                    
                    } 
                }
            }
        }
        if($flag == 1){
            return true ;
        }
        $this->message = ('The '.$this->column.' filed must be unique For All Country');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return  $this->message;
    }
}
