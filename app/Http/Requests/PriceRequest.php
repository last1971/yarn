<?php

namespace App\Http\Requests;

use App\Traits\AuthorizeAdminRequest;
use Illuminate\Foundation\Http\FormRequest;

class PriceRequest extends FormRequest
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
            'min' => 'required|integer',
            'price' => 'required|numeric',
            'product_id' => 'required|uuid',
        ];
    }
}
