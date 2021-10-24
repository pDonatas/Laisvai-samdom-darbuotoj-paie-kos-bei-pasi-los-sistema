<?php

namespace Tests\Feature\App\Http\Controllers\API\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\BaseTestCase;
use Tests\Feature\App\Http\Requests\UserRequestTest;
use Tests\TestCase;

class RegisterMethodTest extends BaseTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        User::create([
            'email' => 'test@test.com',
            'name' => 'test',
            'password' => \Hash::make('password')
        ]);
    }

    /**
     * @covers \App\Http\Controllers\API\Auth\AuthController::register
     */
    public function test_user_can_not_register_when_already_exists()
    {
        $response = $this->postJson('/api/register', [
            'email' => 'test@test.com',
            'password' => 'test user pass',
            'confirm_password' => 'test user pass',
            'name' => 'test'
        ]);

        $response->assertJsonFragment([
            'The email has already been taken.'
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }
}
