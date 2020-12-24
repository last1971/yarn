<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'article_id' => 'nullable|uuid',
            'name' => 'string',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|uuid',
            'picture_id' => 'nullable|uuid',
        ];
    }
}
