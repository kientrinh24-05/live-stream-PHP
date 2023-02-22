<?php

namespace App\Http\Requests\money\Expense;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ExpenseFormRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'date' => 'required|date_format:Y-m-d H:i:s',
            'cate' => 'required|integer',
            'payment_method_type' => 'required|string|in:Cash,Transfer,E-Cash,Other',
            'amount_vnd' => 'required|integer',
            'amount_usd' => 'nullable|numeric',
            'rate' => 'nullable|integer',
            'name' => 'nullable|required_with:account,bank_name|string|min:6|max:30',
            'account' => 'nullable|required_with:name,bank_name|numeric|digits_between:10,20',
            'bank_name' => 'nullable|required_with:account,name|string|min:2|max:30',
            'note' => 'nullable|string'
        ];
    }

    public function attributes(): array
    {
        return [
            'date' => 'Thời gian thanh toán',
            'cate' => 'Tên loại chi phí',
            'payment_method_type' => 'Phương phức thanh toán',
            'amount_vnd' => 'Số tiền VNĐ',
            'amount_usd' => 'Số tiền USD',
            'rate' => 'Tỉ giá USD',
            'name' => 'Họ và tên chủ tài khoản',
            'account' => 'Số tài khoản',
            'bank_name' => 'Tên ngân hàng, ví điện tử',
            'note' => 'Ghi chú, mô tả'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
