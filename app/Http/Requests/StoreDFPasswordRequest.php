<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDFPasswordRequest extends FormRequest
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
            'new-password-default' => 'required|min:8',
            'new-password-default-confirm' => 'required|min:8',
        ];
    }

    public function messages()
    {
        return [
            'new-password-default.required' => __('message.field-isnt-empty'),
            'new-password-default.min' => 'Trường này ít nhất là 8 ký tự',
            'new-password-default-confirm.required' => __('message.field-isnt-empty'),
            'new-password-default-confirm.min' => 'Trường này ít nhất là 8 ký tự',
        ];
    }
}
