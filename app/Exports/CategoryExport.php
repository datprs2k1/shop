<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;

class CategoryExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Category::all(['id', 'name', 'description', 'created_at', 'updated_at']);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tên danh mục',
            'Mô tả',
            'Ngày tạo',
            'Ngày sửa',
        ];
    }

    public function title(): string
    {
        return 'Danh mục';
    }
}
