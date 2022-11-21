<?php

namespace App\Http\Requests\Cart;

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
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
        ];
    }

    public function attributes()
    {
        return [
            'product_id' => 'Sản phẩm',
            'quantity' => 'Số lượng',
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => ':attribute không được để trống',
            'product_id.exists' => ':attribute không tồn tại',
            'quantity.required' => ':attribute không được để trống',
            'quantity.numeric' => ':attribute phải là số',
            'quantity.min' => ':attribute phải lớn hơn 0',
        ];
    }
}
