<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'email' => 'required|email|unique:accounts|max:100',
            'username' => 'required|max:200',
            'phone_number' => 'required|max:30',
            'code_user' => 'required|integer|unique:accounts|digits:4',
            'department_id' => 'required',
            'role_id' => 'required',
            'workarea_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'Email không đúng định dạng',
            'email.required' => __('message.field-isnt-empty'),
            'email.unique' => 'Email đã tồn tại',
            'username.required' => __('message.field-isnt-empty'),
            'username.max' => 'Trường này không được quá 200 ký tự',
            'phone_number.required' => __('message.field-isnt-empty'),
            'phone_number.max' => 'Trường này không được quá 30 ký tự',
            'code_user.required' => __('message.field-isnt-empty'),
            'code_user.integer' => 'Trường này phải là số',
            'code_user.digits' => 'trường này phải là 4 chữ số',
            'code_user.unique' => 'Mã người dùng đã tồn tại',
            'department_id.required' => __('message.field-isnt-empty'),
            'role_id.required' => __('message.field-isnt-empty'),
            'workarea_id.required' => __('message.field-isnt-empty'),
        ];
    }
}
