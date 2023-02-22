<?php

namespace App\Http\Requests\Search;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SLogActionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'filter1' => 'nullable|string|min:2|max:30|',
            'filter2' => 'nullable|numeric',
            'filter3' => 'nullable|string|min:2|max:30|',
            'datatableSearch' => 'nullable|string',
            'start_date' => 'nullable|date_format:Y-m-d|before_or_equal:end_date',
            'end_date' => 'nullable|date_format:Y-m-d|after_or_equal:start_date'
        ];
    }

    public function messages(): array
    {
        return [
            'filter1.string' => ':attribute không hợp lệ.',
            'filter1.min' => ':attribute tối thiểu 2 ký tự.',
            'filter1.max' => ':attribute tối đa 30 ký tự',
            'filter2.numeric' => ':attribute không hợp lệ.',
            'filter3.string' => ':attribute không hợp lệ.',
            'filter3.min' => ':attribute tối thiểu 2 ký tự.',
            'filter3.max' => ':attribute tối đa 30 ký tự',
            'start_date.date_format' => ':attribute không hợp lệ.',
            'start_date.before_or_equal' => 'Ngày bắt đầu phải nhỏ hơn hoặc bằng ngày kết thúc',
            'end_date.date_format' => ':attribute không hợp lệ.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu',
            'datatableSearch.string' => ':attribute không hợp lệ.',
        ];
    }

    public function attributes(): array
    {
        return [
            'filter1' => 'Log name',
            'filter2' => 'Người dùng',
            'filter3' => 'Mô tả action',
            'start_date' => 'Ngày bắt đầu',
            'end_date' => 'Ngày kết thúc',
            'datatableSearch' => 'Url hoặc Ip Address'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

}
