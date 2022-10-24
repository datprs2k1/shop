<?php

namespace App\Http\Requests\Category;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'name' => [
                'required',
                'string',
                Rule::unique(Category::class),
            ],
            'description' => [
                'required',
                'string',
            ],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên danh mục',
            'description' => 'Mô tả'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được để trống.',
            'string' => ':attribute phải là kí tự.',
            'unique' => ':attribute đã tồn tại.'
        ];
    }
}
