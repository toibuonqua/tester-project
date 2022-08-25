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
            'email' => 'bail|required|email|unique:accounts',
            'username' => 'required',
            'phone_number' => 'required',
            'code_user' => 'required',
            'department_id' => 'required',
            'role_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'Email không đúng định dạng',
            'email.required' => 'Trường email trống',
            'email.unique' => 'Email đã tồn tại trong hệ thống',
            'username.required' => 'Trường họ và tên trống',
            'phone_number.required' => 'Trường số điện thoại trống',
            'department_id.required' => 'Chưa chọn phòng ban',
            'role_id' => 'Chưa chọn chức vụ',
        ];
    }
}
