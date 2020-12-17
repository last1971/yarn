<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticleRequest extends FormRequest
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
        if ($this->route()->getName() === 'article.store') {
            return [ 'name' => 'required|string|unique:articles' ];
        } else {
            $article = $this->route()->parameters['article'];
            return
                [
                    'name' => ['string', Rule::unique('articles')->ignore($article)],
                    'content' => 'string|nullable'
                ];
        }
    }
}
