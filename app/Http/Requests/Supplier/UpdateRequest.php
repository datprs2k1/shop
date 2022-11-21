<?php

namespace App\Http\Requests\Supplier;

use App\Models\Supplier;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'name' => [
                'required',
                'string',
                Rule::unique(Supplier::class, 'name')->ignore($this->supplier),
            ],
            'description' => [
                'required',
                'string',
            ],
            'address' => [
                'required',
                'string',
            ],
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique(Supplier::class)->ignore($this->supplier),
            ],
            'phone' => [
                'required',
                'string',
                'digits:10',
                Rule::unique(Supplier::class)->ignore($this->supplier),
            ],
            'website' => [
                'required',
                'string',
                Rule::unique(Supplier::class)->ignore($this->supplier),
            ],
            'logo' => [
                'nullable',
            ],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên danh mục',
            'description' => 'Mô tả',
            'address' => 'Địa chỉ',
            'email' => 'Email',
            'phone' => 'Số điện thoại',
            'website' => 'Website',
            'logo' => 'Logo',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được để trống.',
            'string' => ':attribute phải là kí tự.',
            'unique' => ':attribute đã tồn tại.',
            'digits' => ':attribute phải là số và có độ dài :digits.',
            'email' => ':attribute không đúng định dạng.',
            'image' => ':attribute phải là hình ảnh.',
            'logo.max' => ':attribute có dung lượng không được quá :max MB.',
        ];
    }
}
