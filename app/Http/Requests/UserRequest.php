<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules = [
            'password' => 'sometimes|string',
            'new_password' => 'sometimes|string',
            'confirm_password' => 'sometimes|string',
            'photo' => 'sometimes|file|mimes:jpeg,bmp,png,gif,svg',
            'name' => 'required|string',
            'email' => 'required|email'
        ];

        if ($this->route()->getActionMethod() == 'register') {
            $rules['password'] = 'required|string';
        }

        return $rules;
    }
}
