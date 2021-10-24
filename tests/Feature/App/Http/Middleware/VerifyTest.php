<?php

namespace Tests\Feature\App\Http\Middleware;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VerifyTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @covers \App\Http\Middleware\verify::handle
     */
    public function test_handle_unverified_user()
    {
        $user = User::create([
            'email' => $this->faker->email,
            'password' => $this->faker->password,
            'name' => $this->faker->name,
            'type' => 0
        ]);

        $response = $this->actingAs($user)->get('/posts/index');

        $response->assertRedirect('/home');
    }

    /**
     * @covers \App\Http\Middleware\verify::handle
     */
    public function test_handle_verified_user()
    {
        $user = User::create([
            'email' => $this->faker->email,
            'password' => $this->faker->password,
            'name' => $this->faker->name,
            'type' => 1
        ]);

        $response = $this->actingAs($user)->get('/posts/index');

        $this->assertEquals(200, $response->getStatusCode());
    }
}
