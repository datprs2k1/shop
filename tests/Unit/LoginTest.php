<?php

namespace Tests\Unit;

use Tests\TestCase;


class LoginTest extends TestCase
{

    /**
     * A basic unit test example.
     * @dataProvider loginProvider
     *
     * @return void
     */
    public function test_login($data, $expectStatus, $expectResult)
    {
        $response = $this->postJson('/api/login', $data);

        $response->assertStatus($expectStatus);

        $response->assertJson($expectResult);
    }

    public function loginProvider()
    {
        return [
            "Email và mật khẩu trống" => [
                [
                    'email' => '',
                    'password' => ''
                ],
                422,
                [
                    'message' => 'Email không được để trống. (and 1 more error)',
                    'errors' => [
                        'email' => [
                            'Email không được để trống.'
                        ],
                        'password' => [
                            'Mật khẩu không được để trống.'
                        ]
                    ]
                ]
            ],
            "Email trống" => [
                [
                    'email' => '',
                    'password' => '123456'
                ],
                422,
                [
                    'message' => 'Email không được để trống.',
                    'errors' => [
                        'email' => [
                            'Email không được để trống.'
                        ]
                    ]
                ]
            ],
            "Mật khẩu trống" => [
                [
                    'email' => 'admin@gmail.com',
                    'password' => ''
                ],
                422,
                [
                    'message' => 'Mật khẩu không được để trống.',
                    'errors' => [
                        'password' => [
                            'Mật khẩu không được để trống.'
                        ]
                    ]
                ]
            ],
            "Sai tài khoản hoặc mật khẩu" => [
                [
                    'email' => 'admin@gmail.com',
                    'password' => '1234567'
                ],
                422,
                [
                    'message' => 'Sai tài khoản hoặc mật khẩu.',
                ]
            ],
            "Đăng nhập thành công" => [
                [
                    'email' => 'admin@gmail.com',
                    'password' => '123456'
                ],
                200,
                [
                    'message' => 'Đăng nhập thành công.',
                ]
            ]
        ];
    }
}
