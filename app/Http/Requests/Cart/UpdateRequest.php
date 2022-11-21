<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'quantity' => 'required|numeric|min:1',
        ];
    }

    public function attributes()
    {
        return [
            'quantity' => 'Số lượng',
        ];
    }

    public function messages()
    {
        return [
            'quantity.required' => ':attribute không được để trống',
            'quantity.numeric' => ':attribute phải là số',
            'quantity.min' => ':attribute phải lớn hơn 0',
        ];
    }
}
