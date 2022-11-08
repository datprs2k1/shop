<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\CategoryRepository;
use Faker\Factory as Faker;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    protected $category;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();
        // chuẩn bị dữ liệu test
        $this->category = [
            'name' => $this->faker->name,
            'description' => $this->faker->name,
        ];
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function getToken()
    {
        $user = User::where('email', 'admin@gmail.com')->first();

        $token = JWTAuth::fromUser($user);
        return $token;
    }

    public function test_get_list_without_login()
    {
        $response = $this->getJson(route('category.index'));

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.'
        ]);

        $response->assertUnauthorized();
    }

    public function test_get_list_with_login()
    {
        $token = $this->getToken();

        $this->withHeader('Authorization', 'Bearer ' . $token);

        $response = $this->getJson(route('category.index'));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'created_at',
                    'updated_at',
                ]
            ],
        ]);

        $this->assertAuthenticated();
    }

    public function test_add_without_login()
    {
        $response = $this->postJson(route('category.store'), $this->category);

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.'
        ]);
        $response->assertUnauthorized();
    }

    public function test_add_with_login_all_empty()
    {
        $token = $this->getToken();

        $this->withHeader('Authorization', 'Bearer ' . $token);

        $response = $this->postJson(route('category.store'), [
            'name' => '',
            'description' => '',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'description']);
        $this->assertAuthenticated();
    }

    public function test_add_with_login_name_empty()
    {
        $token = $this->getToken();

        $this->withHeader('Authorization', 'Bearer ' . $token);

        $response = $this->postJson(route('category.store'), [
            'name' => '',
            'description' => '',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
        $this->assertAuthenticated();
    }

    public function test_add_with_login_description_empty()
    {
        $token = $this->getToken();

        $this->withHeader('Authorization', 'Bearer ' . $token);

        $response = $this->postJson(route('category.store'), [
            'name' => '',
            'description' => '',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['description']);
        $this->assertAuthenticated();
    }

    public function test_add_with_login_name_unique()
    {
        $token = $this->getToken();

        $this->withHeader('Authorization', 'Bearer ' . $token);

        $response = $this->postJson(route('category.store'), [
            'name' => Category::first()->name,
            'description' => '',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
        $this->assertAuthenticated();
    }

    public function test_add_with_login_success()
    {
        $token = $this->getToken();

        $this->withHeader('Authorization', 'Bearer ' . $token);

        $response = $this->postJson(route('category.store'), $this->category);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Thêm thành công.'
        ]);

        $this->assertAuthenticated();
    }
}
