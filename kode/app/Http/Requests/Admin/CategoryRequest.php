<?php

namespace App\Http\Requests\Admin;

use App\Rules\Admin\TranslationUniqueCheckRule;
use App\Rules\General\FileExtentionCheckRule;
use App\Rules\General\FileLengthCheckRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\StatusEnum;

class CategoryRequest extends FormRequest
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

        $size = explode('x',  getFilePaths()['category']['size']);

        return [
            'name'                  => ['required', new TranslationUniqueCheckRule('Category', 'name', request()->id)],
            'sort_details'          => ['required',"max:255"],
            'article_display_flag'  => ['required_without:ticket_display_flag', Rule::in(StatusEnum::toArray())],
            'ticket_display_flag'   => ['required_without:article_display_flag', Rule::in(StatusEnum::toArray())],
            'image'                 => [
                'image',
                new FileExtentionCheckRule(json_decode(site_settings('mime_types'), true)),
                new FileLengthCheckRule($size[0], $size[1])
            ]
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'       => translate('Name Feild Must Be Required'),
            'name.unique'         => translate('Category Name Must Be Unique'),
            'sort_details.unique' => translate('Short Details Is Required'),
        ];
    }
}
