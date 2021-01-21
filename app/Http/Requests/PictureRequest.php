<?php

namespace App\Http\Requests;

use App\Traits\AuthorizeAdminRequest;
use Illuminate\Foundation\Http\FormRequest;

class PictureRequest extends FormRequest
{
    use AuthorizeAdminRequest;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->route()->getName() === 'picture.store') {
            return [
                'picture' => 'required|image',
                'model' => 'required|string',
                'id' =>'required|uuid',
            ];
        }
        return [
            'picture' => 'required|image',
            'slug' => 'required|string'
        ];
    }
}
