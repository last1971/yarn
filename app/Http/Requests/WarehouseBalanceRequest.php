<?php

namespace App\Http\Requests;

use App\Traits\AuthorizeAdminRequest;
use Illuminate\Foundation\Http\FormRequest;

class WarehouseBalanceRequest extends FormRequest
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
            'balance' => 'integer|min:0',
            'warehouse_id' => 'uuid',
            'product_id' => 'uuid',
        ];
    }
}
