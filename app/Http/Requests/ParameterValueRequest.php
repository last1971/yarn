<?php

namespace App\Http\Requests;

use App\Traits\AuthorizeAdminRequest;
use Illuminate\Foundation\Http\FormRequest;

class ParameterValueRequest extends FormRequest
{
    use AuthorizeAdminRequest;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => 'required|string',
            'parameter_name_id' => 'nullable:string',
            'parameter_unit_id' => 'nullable:string',
            'numeric_value' => 'nullable:numeric',
            'fraction' => 'nullable:numeric',
            'string_value' => 'nullable:string',
        ];
    }
}
