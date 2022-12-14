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
            'address_id' => 'required|integer|exists:addresses,id',
            'method' => 'required|integer',
        ];
    }

    public function attributes()
    {
        return [
            'address_id' => 'Địa chỉ',
            'method' => 'Phương thức thanh toán',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được để trống',
            'integer' => ':attribute phải là số nguyên',
            'exists' => ':attribute không tồn tại',
        ];
    }
}
