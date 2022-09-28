<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'old-password' => 'required',
            'new-password' => 'required|min:8',
            'confirm-new-password' => 'required|min:8',
        ];
    }

    public function messages()
    {
        return [
            'old-password.required' => __('message.field-isnt-empty'),
            'new-password.required' => __('message.field-isnt-empty'),
            'new-password.min' => 'Trường này không được ít hơn 8 ký tự',
            'confirm-new-password.required' => __('message.field-isnt-empty'),
            'confirm-new-password.min' => 'Trường này không được ít hơn 8 ký tự',
        ];
    }
}
