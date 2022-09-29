<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkareaRequest extends FormRequest
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
            'work_areas_code' => 'required|unique:workarea|max:6',
            'name' => 'required|max:6',
        ];
    }

    public function messages()
    {
        return [
            'work_areas_code.required' => __('message.field-isnt-empty'),
            'work_areas_code.unique' => 'Mã khu vực đã tồn tại',
            'work_areas_code.max' => 'Mã khu vực tối đa 6 ký tự',
            'name.required' => __('message.field-isnt-empty'),
            'name.max' => 'Tên khu vực tối đa 6 ký tự',
        ];
    }
}
