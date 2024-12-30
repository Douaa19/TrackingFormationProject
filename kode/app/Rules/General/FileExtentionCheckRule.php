<?php

namespace App\Rules\General;

use Illuminate\Contracts\Validation\Rule;

class FileExtentionCheckRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $extention;
    public $type;
    public $message;
    public function __construct($extention,$type = 'image')
    {
       $this->extention = $extention;
       $this->type = $type;;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value){

        $flag = 1;
        if(is_array($value)){

            if(count($value) > (int) site_settings('max_file_upload')){
                $this->message = " ".translate("You Can Not Upload More Than ").site_settings('max_file_upload').translate(' File At a Time');
                $flag = 0;
            }
            
            else{
                foreach($value as $file){
                    $fileSizeInBytes = $file->getSize();
                    if( round($fileSizeInBytes / 1024) >  (int) site_settings('max_file_size')){
                        $this->message = translate($this->type.' Size Must be Under '). site_settings('max_file_size'). translate('KB');
                        $flag = 0;
                        break;
                    }
                    elseif(!in_array($file->getClientOriginalExtension(), $this->extention)){
                        $flag = 0;
                        $this->message = translate($this->type.' Must be '.implode(", ", $this->extention).' Format');
                        break;
                    }
                }
            }

        }
        else{
            $fileSizeInBytes = $value->getSize();
            if( round($fileSizeInBytes / 1024) >  (int) site_settings('max_file_size')){
                $this->message = translate($this->type.' Size Must be Under '). site_settings('max_file_size'). translate('KB');
                $flag = 0;
            }
            elseif(!in_array($value->getClientOriginalExtension(), $this->extention)){
                $this->message = translate($this->type.' Must be '.implode(", ", $this->extention).' Format');
                $flag = 0;
            }
        }

        if( $flag == 1){
            return true;
        }
        return false;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
