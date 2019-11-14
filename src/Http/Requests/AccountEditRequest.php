<?php

namespace Wingsline\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountEditRequest extends FormRequest
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
        $auth_user = Auth()->user();

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email,' . $auth_user->id
            ],
            'password' => [
                'present',
                'string',
                'nullable',
                'min:8',
                'confirmed'
            ],
            'password_confirmation' => ['present', 'string', 'nullable'],
        ];
    }
}
