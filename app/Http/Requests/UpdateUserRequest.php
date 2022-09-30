<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'username' => 'required|regex:/^[\w\s.]{0,}$/u|max:100',
            'phone_number' => 'required|regex:/^([\d]{3} [\d]{3} [\d]{3})*([\d]{3}-[\d]{3}-[\d]{3})*([\d]{3}\.[\d]{3}\.[\d]{3})*$/u|max:15',
            'code_user' => 'required|numeric|digitsbetween:1,10',
            'department_id' => 'required',
            'role_id' => 'required',
            'workarea_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => __('message.field-isnt-empty'),
            'username.regex' => 'Trường này chỉ nhận ký tự và số',
            'username.max' => 'Trường này không được quá 100 ký tự',
            'phone_number.required' => __('message.field-isnt-empty'),
            'phone_number.regex' => 'Số điện thoại không đúng định dạng',
            'phone_number.digits' => 'Trường này không được quá 15 chữ số',
            'code_user.required' => __('message.field-isnt-empty'),
            'code_user.numeric' => 'Trường này phải là số',
            'code_user.digitsbetween' => 'trường này từ 1 đến 10 chữ số',
            'department_id.required' => __('message.field-isnt-empty'),
            'role_id.required' => __('message.field-isnt-empty'),
            'workarea_id.required' => __('message.field-isnt-empty'),
        ];
    }
}
