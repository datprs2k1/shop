<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositories\CategoryRepository;
use Faker\Factory as Faker;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */

    protected $category;
    protected $token;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::where('email', 'admin@gmail.com')->first();

        $this->token = JWTAuth::fromUser($user);
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * A basic unit test example.
     * @dataProvider addProvider
     * @return void
     */

    public function test_add_category($data, $expectStatus, $expectResult)
    {

        $this->withHeader('Authorization', 'Bearer ' . $this->token);

        $response = $this->postJson('/api/admin/category', $data);

        $response->assertStatus($expectStatus);

        $response->assertJson($expectResult);
    }

    /**
     * A basic unit test example.
     * @dataProvider editProvider
     * @return void
     */


    public function test_edit_category($id, $data, $expectStatus, $expectResult)
    {

        $this->withHeader('Authorization', 'Bearer ' . $this->token);

        $response = $this->putJson('/api/admin/category/' . $id, $data);

        $response->assertStatus($expectStatus);

        $response->assertJson($expectResult);
    }

    /**
     * A basic unit test example.
     * @dataProvider deleteProvider
     * @return void
     */


    public function test_delete_category($id, $expectStatus, $expectResult)
    {

        $this->withHeader('Authorization', 'Bearer ' . $this->token);

        $response = $this->deleteJson('/api/admin/category/' . $id);

        $response->assertStatus($expectStatus);

        $response->assertJson($expectResult);
    }

    public function addProvider()
    {
        return [
            "Tên và mô tả để trống" => [
                [
                    'name' => '',
                    'description' => '',
                ],
                422,
                [
                    "message" => "Tên danh mục không được để trống. (and 1 more error)",
                    "errors" => [
                        "name" => [
                            "Tên danh mục không được để trống."
                        ],
                        "description" => [
                            "Mô tả không được để trống."
                        ]
                    ]
                ]
            ],
            "Tên để trống" => [
                [
                    'name' => '',
                    'description' => Faker::create()->name(),
                ],
                422,
                [
                    "message" => "Tên danh mục không được để trống.",
                    "errors" => [
                        "name" => [
                            "Tên danh mục không được để trống."
                        ]
                    ]
                ]
            ],
            "Mô tả để trống" => [
                [
                    'name' => Faker::create()->name(),
                    'description' => '',
                ],
                422,
                [
                    "message" => "Mô tả không được để trống.",
                    "errors" => [
                        "description" => [
                            "Mô tả không được để trống."
                        ]
                    ]
                ]
            ],
            "Tên đã tồn tại" => [
                [
                    'name' => "Rau - Củ - Trái Cây",
                    'description' => Faker::create()->name(),
                ],
                422,
                [
                    "message" => "Tên danh mục đã tồn tại.",
                    "errors" => [
                        "name" => [
                            "Tên danh mục đã tồn tại."
                        ]
                    ]
                ]
            ],
            "Thêm thành công" => [
                [
                    'name' => Faker::create()->name(),
                    'description' => Faker::create()->name(),
                ],
                200,
                [
                    "message" => "Thêm thành công."
                ]
            ]
        ];
    }
    public function editProvider()
    {
        return [
            "Không tồn tại" => [
                100,
                [
                    'name' => Faker::create()->name(),
                    'description' => Faker::create()->name(),
                ],
                422,
                [
                    "message" => "Không tồn tại."
                ]
            ],
            "Tên và mô tả để trống" => [
                1,
                [
                    'name' => '',
                    'description' => '',
                ],
                422,
                [
                    "message" => "Tên danh mục không được để trống. (and 1 more error)",
                    "errors" => [
                        "name" => [
                            "Tên danh mục không được để trống."
                        ],
                        "description" => [
                            "Mô tả không được để trống."
                        ]
                    ]
                ]
            ],
            "Tên để trống" => [
                1,
                [
                    'name' => '',
                    'description' => Faker::create()->name(),
                ],
                422,
                [
                    "message" => "Tên danh mục không được để trống.",
                    "errors" => [
                        "name" => [
                            "Tên danh mục không được để trống."
                        ]
                    ]
                ]
            ],
            "Mô tả để trống" => [
                1,
                [
                    'name' => Faker::create()->name(),
                    'description' => '',
                ],
                422,
                [
                    "message" => "Mô tả không được để trống.",
                    "errors" => [
                        "description" => [
                            "Mô tả không được để trống."
                        ]
                    ]
                ]
            ],
            "Tên đã tồn tại" => [
                1,
                [
                    'name' => "Thịt - Trứng - Hải Sản",
                    'description' => Faker::create()->name(),
                ],
                422,
                [
                    "message" => "Tên danh mục đã tồn tại.",
                    "errors" => [
                        "name" => [
                            "Tên danh mục đã tồn tại."
                        ]
                    ]
                ]
            ],
            "Sửa thành công" => [
                1,
                [
                    'name' => Faker::create()->name(),
                    'description' => Faker::create()->name(),
                ],
                200,
                [
                    "message" => "Sửa thành công."
                ]
            ]
        ];
    }

    public function deleteProvider()
    {
        return [
            "Không tồn tại" => [
                100,
                422,
                [
                    "message" => "Không tồn tại."
                ]
            ],
            "Xoá thành công" => [
                1,
                200,
                [
                    "message" => "Xoá thành công."
                ]
            ]
        ];
    }
}
âbdkasbd