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
            'new-password' => 'required|regex:/^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{8,}$/u',
            'confirm-new-password' => 'required|regex:/^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{8,}$/u',
        ];
    }

    public function messages()
    {
        return [
            'old-password.required' => __('message.field-isnt-empty'),
            'new-password.required' => __('message.field-isnt-empty'),
            'new-password.regex' => 'Mật khẩu mới không hợp lệ',
            'confirm-new-password.required' => __('message.field-isnt-empty'),
            'confirm-new-password.regex' => 'Mật khẩu mới không hợp lệ',
        ];
    }
}
