<?php

namespace App\Http\Requests;

use App\Traits\AuthorizeAdminRequest;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'article_id' => 'nullable|uuid',
            'name' => 'string',
            'description' => 'nullable|string',
            'picture_id' => 'nullable|uuid',
            'producer_id' => 'nullable|uuid',
            'category_id' => 'required|uuid',
        ];
    }
}
