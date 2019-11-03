<?php

namespace Wingsline\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title' => 'required',
            'text' => 'required',
            'publish_date' => 'date',
            'published' => 'boolean',
            'original_content' => 'boolean',
            'tags_text' => 'present',
            'external_url' => '',
        ];
    }
}
