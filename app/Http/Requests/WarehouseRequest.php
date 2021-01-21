<?php

namespace App\Http\Requests;

use App\Traits\AuthorizeAdminRequest;
use Illuminate\Foundation\Http\FormRequest;

class WarehouseRequest extends FormRequest
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
            'name' => 'nullable|string',
            'supplier_id' => 'uuid',
        ];
    }
}
