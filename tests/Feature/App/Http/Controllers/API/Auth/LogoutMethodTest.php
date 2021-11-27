<?php

namespace Tests\Feature\App\Http\Controllers\API\Auth;

use App\Http\Services\Auth\TokenService;
use App\User;
use Mockery\MockInterface;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LogoutMethodTest extends TestCase
{
    protected $service;

    public function setUp(): void
    {
        parent::setUp();

        User::create([
            'name' => 'test',
            'email' => 'test_logout@test.com',
            'password' => 'test',
            'token' => 'WCtJYzV1TEtiRCt2cHdQYkNqbytuelFEMVY5L3RvTGZ1SWZjM216cDZYTT0='
        ]);


        $mock = $this->mock(TokenService::class, function (MockInterface $mock) {
            $mock->shouldReceive('encryptToken')->andReturn('WCtJYzV1TEtiRCt2cHdQYkNqbytuelFEMVY5L3RvTGZ1SWZjM216cDZYTT0=');
            $mock->shouldReceive('decryptToken')->andReturn([0 => 0]);
        });

        $this->service = $mock;
    }

    /**
     * @covers \App\Http\Controllers\API\Auth\AuthController::logout
     */
    public function test_user_can_not_register_when_already_exists()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->service->encryptToken(strtotime('+1 minute'))
        ])->get('/api/logout');

        $response->assertJsonFragment([
            'User logged out successfully'
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }
}
