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
            'T??n v?? m?? t??? ????? tr???ng' => [
                [
                    'name' => '',
                    'description' => '',
                ],
                422,
                [
                    'message' =>
                        'T??n danh m???c kh??ng ???????c ????? tr???ng. (and 1 more error)',
                    'errors' => [
                        'name' => ['T??n danh m???c kh??ng ???????c ????? tr???ng.'],
                        'description' => ['M?? t??? kh??ng ???????c ????? tr???ng.'],
                    ],
                ],
            ],
            'T??n ????? tr???ng' => [
                [
                    'name' => '',
                    'description' => Faker::create()->name(),
                ],
                422,
                [
                    'message' => 'T??n danh m???c kh??ng ???????c ????? tr???ng.',
                    'errors' => [
                        'name' => ['T??n danh m???c kh??ng ???????c ????? tr???ng.'],
                    ],
                ],
            ],
            'M?? t??? ????? tr???ng' => [
                [
                    'name' => Faker::create()->name(),
                    'description' => '',
                ],
                422,
                [
                    'message' => 'M?? t??? kh??ng ???????c ????? tr???ng.',
                    'errors' => [
                        'description' => ['M?? t??? kh??ng ???????c ????? tr???ng.'],
                    ],
                ],
            ],
            'T??n ???? t???n t???i' => [
                [
                    'name' => 'Rau - C??? - Tr??i C??y',
                    'description' => Faker::create()->name(),
                ],
                422,
                [
                    'message' => 'T??n danh m???c ???? t???n t???i.',
                    'errors' => [
                        'name' => ['T??n danh m???c ???? t???n t???i.'],
                    ],
                ],
            ],
            'Th??m th??nh c??ng' => [
                [
                    'name' => Faker::create()->name(),
                    'description' => Faker::create()->name(),
                ],
                200,
                [
                    'message' => 'Th??m th??nh c??ng.',
                ],
            ],
        ];
    }
    public function editProvider()
    {
        return [
            'Kh??ng t???n t???i' => [
                100,
                [
                    'name' => Faker::create()->name(),
                    'description' => Faker::create()->name(),
                ],
                422,
                [
                    'message' => 'Kh??ng t???n t???i.',
                ],
            ],
            'T??n v?? m?? t??? ????? tr???ng' => [
                1,
                [
                    'name' => '',
                    'description' => '',
                ],
                422,
                [
                    'message' =>
                        'T??n danh m???c kh??ng ???????c ????? tr???ng. (and 1 more error)',
                    'errors' => [
                        'name' => ['T??n danh m???c kh??ng ???????c ????? tr???ng.'],
                        'description' => ['M?? t??? kh??ng ???????c ????? tr???ng.'],
                    ],
                ],
            ],
            'T??n ????? tr???ng' => [
                1,
                [
                    'name' => '',
                    'description' => Faker::create()->name(),
                ],
                422,
                [
                    'message' => 'T??n danh m???c kh??ng ???????c ????? tr???ng.',
                    'errors' => [
                        'name' => ['T??n danh m???c kh??ng ???????c ????? tr???ng.'],
                    ],
                ],
            ],
            'M?? t??? ????? tr???ng' => [
                1,
                [
                    'name' => Faker::create()->name(),
                    'description' => '',
                ],
                422,
                [
                    'message' => 'M?? t??? kh??ng ???????c ????? tr???ng.',
                    'errors' => [
                        'description' => ['M?? t??? kh??ng ???????c ????? tr???ng.'],
                    ],
                ],
            ],
            'T??n ???? t???n t???i' => [
                1,
                [
                    'name' => 'Th???t - Tr???ng - H???i S???n',
                    'description' => Faker::create()->name(),
                ],
                422,
                [
                    'message' => 'T??n danh m???c ???? t???n t???i.',
                    'errors' => [
                        'name' => ['T??n danh m???c ???? t???n t???i.'],
                    ],
                ],
            ],
            'S???a th??nh c??ng' => [
                1,
                [
                    'name' => Faker::create()->name(),
                    'description' => Faker::create()->name(),
                ],
                200,
                [
                    'message' => 'S???a th??nh c??ng.',
                ],
            ],
        ];
    }

    public function deleteProvider()
    {
        return [
            'Kh??ng t???n t???i' => [
                100,
                422,
                [
                    'message' => 'Kh??ng t???n t???i.',
                ],
            ],
            'Xo?? th??nh c??ng' => [
                1,
                200,
                [
                    'message' => 'Xo?? th??nh c??ng.',
                ],
            ],
        ];
    }
}
asmr
