<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use HTMLPurifier;

class SanitizeHtml implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
       
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
        $cleanValue = preg_replace("/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/i", '', $value);
        return $cleanValue === $value;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return  translate("Warning: Your Input Contains Potentially Harmful Content");
    }
}
