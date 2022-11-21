<?php

namespace App\Http\Requests\Product;

use App\Enums\ProductStatus;
use App\Models\Category;
use App\Models\Product;
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
                Rule::unique(Product::class, 'name')->ignore($this->product),
            ],
            'description' => [
                'required',
                'string',
            ],
            'image' => [
                'nullable'
            ],
            'manual' => [
                'required',
                'string',
            ],
            'price' => [
                'required',
                'numeric',
            ],
            'unit' => [
                'required',
                'numeric',
            ],
            'status' => [
                'required',
                'numeric',
                Rule::in(ProductStatus::getValues()),
            ],
            'category_id' => [
                'required',
                'numeric',
                Rule::exists(Category::class, 'id'),
            ],
            'supplier_id' => [
                'required',
                'numeric',
                Rule::exists(Supplier::class, 'id'),
            ],
            'add_images' => [
                'nullable'
            ],
            'delete_images' => [
                'nullable'
            ],

        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên danh mục',
            'description' => 'Mô tả',
            'image' => 'Ảnh chính',
            'manual' => 'Hướng dẫn sử dụng',
            'price' => 'Giá',
            'unit' => 'Đơn vị',
            'status' => 'Trạng thái',
            'category_id' => 'Danh mục',
            'supplier_id' => 'Nhà cung cấp',
            'add_images' => 'Ảnh thêm',
            'delete_images' => 'Ảnh xóa',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được để trống.',
            'string' => ':attribute phải là kí tự.',
            'unique' => ':attribute đã tồn tại.',
            'numeric' => ':attribute phải là số.',
            'image' => ':attribute phải là ảnh.',
            'in' => ':attribute không hợp lệ.',
            'exists' => ':attribute không tồn tại.',
        ];
    }
}
