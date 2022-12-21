<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Rau - Củ - Trái Cây',
                'description' => 'Rau - Củ - Trái Cây',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Thịt - Trứng - Hải Sản',
                'description' => 'Thịt - Trứng - Hải Sản',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Thực Phẩm Chế Biến',
                'description' => 'Thực Phẩm Chế Biến',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Thực Phẩm Đông Lạnh',
                'description' => 'Thực Phẩm Đông Lạnh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Thực Phẩm Khô - Gia Vị',
                'description' => 'Thực Phẩm Khô - Gia Vị',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Category::insert($data);
    }
}
