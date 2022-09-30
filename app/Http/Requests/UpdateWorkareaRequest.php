<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkareaRequest extends FormRequest
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
            'work_areas_code' => 'required|regex:/^[\w]{0,}$/u|max:100',
            'name' => 'required|regex:/^[\w\s]{0,}$/u|max:100',
        ];
    }

    public function messages()
    {
        return [
            'work_areas_code.required' => __('message.field-isnt-empty'),
            'work_areas_code.regex' => 'Trường này chỉ chứa ký tự và số',
            'work_areas_code.max' => 'Mã khu vực tối đa 100 ký tự',
            'name.required' => __('message.field-isnt-empty'),
            'name.regex' => 'Trường này chỉ chứa ký tự, số và khoảng trắng',
            'name.max' => 'Tên khu vực tối đa 100 ký tự',
        ];
    }
}
