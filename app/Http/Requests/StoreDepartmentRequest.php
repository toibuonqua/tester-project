<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;

class StoreDepartmentRequest extends FormRequest
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
            'name' => 'required|regex:/^[\w\s]{0,}$/u|max:256|unique:department',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('message.field-isnt-empty'),
            'name.regex' => 'Trường này chỉ chứa số, ký tự và khoảng trắng',
            'name.max' => 'Trường này tối đa là 256 ký tự',
            'name.unique' => 'Tên phòng ban đã tồn tại',
        ];
    }
}
