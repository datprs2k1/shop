<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'ward' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|not_regex:/(0)[0-9]{10}/|digits:10',
            'method' => 'required|integer',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên',
            'city' => 'Thành phố',
            'district' => 'Quận',
            'ward' => 'Phường',
            'address' => 'Địa chỉ',
            'phone' => 'Số điện thoại',
            'method' => 'Phương thức thanh toán',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được để trống',
            'integer' => ':attribute phải là số nguyên',
            'digits' => ':attribute phải có :digits chữ số',
            'not_regex' => ':attribute không hợp lệ',
        ];
    }
}
