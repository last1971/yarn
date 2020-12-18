<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PictureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // need check for admin
        return true;
    }

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
