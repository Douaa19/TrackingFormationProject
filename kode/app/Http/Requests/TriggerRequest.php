<?php

namespace App\Http\Requests;

use App\Http\Triggers\TriggerConfiguration;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class TriggerRequest extends FormRequest
{


    protected TriggerConfiguration $triggerConfiguration;
    public function __construct(TriggerConfiguration $triggerConfiguration){
        $this->triggerConfiguration = $triggerConfiguration;
    }
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

        $actions        = Arr::get($this->triggerConfiguration->getTriggerConfig(),'actions',[]);
        $conditions     = Arr::get($this->triggerConfiguration->getTriggerConfig(),'conditions',[]);
        $operators     = Arr::get($this->triggerConfiguration->getTriggerConfig(),'operators',[]);

       
        $conditionTypes = array_reduce($conditions, function ($carry, $item) {
            return array_merge($carry, array_keys($item));
        }, []);
        $operatorTypes = array_reduce($operators, function ($carry, $item) {
            return array_merge($carry, array_values($item));
        }, []);

        return [

            'name'                            => ['required','max:191','unique:ticket_triggers,name,'.request()->input('id')],
            'description'                     => ['nullable','max:255'],
            'actions'                         => ['array'],
            'actions.*'                       => [Rule::in(collect($actions)->pluck('name')->toArray())],
            'action_values'                   => ['array'],
            'all'                             => ['array'],
            'all.condition_type'              => ['array'],
            'all.conditions'                  => ['array'],
            'all.condition_type.*'            => [Rule::in($conditionTypes)],
            'all.conditions.*'                => [Rule::in($operatorTypes)],
            'all.condition_value'             => ['array'],
            'any'                             => ['array'],
            'any.condition_type'              => ['array'],
            'any.conditions'                  => ['array'],
            'any.conditions.*'                => [Rule::in($operatorTypes)],
            'any.condition_type.*'            => [Rule::in($conditionTypes)],
            'any.condition_value'             => ['array'],

           
        ];
    }


    
}
