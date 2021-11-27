<?php

namespace Tests\Feature\App\Http\Requests;

use App\User;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRequestTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'email' => 'test@test.com',
            'name' => 'test',
            'password' => \Hash::make('password')
        ]);
    }

    /** @test */
    public function request_should_fail_when_no_email_is_provided()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('api.register'), [
                'password' => $this->faker->password()
            ]);

        $response->assertStatus(
            Response::HTTP_BAD_REQUEST
        );

        $response->assertJsonValidationErrors('email');
    }

    /** @test */
    public function request_should_fail_when_no_password_is_provided()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('api.login'), [
                'email' => $this->faker->email()
            ]);

        $response->assertStatus(
            Response::HTTP_BAD_REQUEST
        );

        $response->assertJsonValidationErrors('password');
    }

    /** @test */
    public function request_should_fail_when_no_name_is_provided()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('api.register'), [
                'email' => $this->faker->email(),
                'password' => $this->faker->password
            ]);

        $response->assertStatus(
            Response::HTTP_BAD_REQUEST
        );

        $response->assertJsonValidationErrors('name');
    }


    /** @test */
    public function request_should_pass_when_data_is_provided()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('api.register'), [
                'email' => 'test_register@test.com',
                'password' => 'password',
                'confirm_password' => 'password',
                'name' => $this->faker->name
            ]);
        $response->assertStatus(Response::HTTP_CREATED);

        $response->assertJsonMissingValidationErrors([
            'email',
            'password',
            'confirm_password'
        ]);
    }
}
