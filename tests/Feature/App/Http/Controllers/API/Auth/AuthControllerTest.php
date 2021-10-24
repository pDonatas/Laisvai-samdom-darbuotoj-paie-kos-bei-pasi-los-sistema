<?php

namespace Tests\Feature\App\Http\Controllers\API\Auth;

use App\Http\Requests\LoginRequest;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Faker\Factory;

/**
 * @covers \App\Http\Controllers\API\Auth\AuthController
 */
class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @var \App\Http\Requests\LoginRequest */
    private $rules;

    /** @var \Illuminate\Validation\Validator */
    private $validator;

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->validator = app()->get('validator');

        $this->rules = (new LoginRequest())->rules();
    }

    public function validationProvider()
    {
        /* WithFaker trait doesn't work in the dataProvider */
        $faker = Factory::create(Factory::DEFAULT_LOCALE);

        return [
            'request_should_fail_when_no_email_is_provided' => [
                'passed' => false,
                'data' => [
                    'password' => $faker->password()
                ]
            ],
            'request_should_fail_when_no_password_is_provided' => [
                'passed' => false,
                'data' => [
                    'email' => $faker->email()
                ]
            ],
            'request_should_pass_when_data_is_provided' => [
                'passed' => true,
                'data' => [
                    'email' => 'test@test.com',
                    'password' => 'password'
                ]
            ]
        ];
    }

    /**
     * @covers \App\Http\Controllers\API\Auth\AuthController::login
     */
    public function test_user_can_view_login()
    {
        $response = $this->get('/login');

        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }

    /**
     * @covers \App\Http\Controllers\API\Auth\AuthController::login
     */
    public function test_user_cannot_view_a_login_form_when_authenticated()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/home');
    }

    /**
     * @covers \App\Http\Controllers\API\Auth\AuthController::login
     */
    public function test_user_can_not_login_with_bad_credentials()
    {
        $response = $this->post('/api/login', [
            'email' => 'bad@email.com',
            'password' => 'badpass'
        ]);

        $response->assertExactJson(['error' => 'Either username and/or password is not correct']);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @covers \App\Http\Controllers\API\Auth\AuthController::login
     * @dataProvider validationProvider
     */
    public function test_login_validations($shouldPass, $mockedRequestData)
    {
        $this->assertEquals(
            $shouldPass,
            $this->validate($mockedRequestData)
        );
    }

    /**
     * @covers \App\Http\Controllers\API\Auth\AuthController::login
     */
    public function test_user_can_login_with_good_credentials(): User
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'test user pass'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);

        $this->be($user);

        return $user;
    }

    /**
     * @covers \App\Http\Controllers\API\Auth\AuthController::login
     */
    public function test_user_cannot_login_with_incorrect_password()
    {
        $user = User::factory()->create([
            'password' => bcrypt('test user pass'),
        ]);

        $response = $this->from('/login')->post('/api/login', [
            'email' => $user->email,
            'password' => 'invalid-password',
        ]);

        $response->assertExactJson(['error' => [
            'username' => 'Email or password is not correct'
        ]]);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $this->assertGuest();
    }

    /**
     * @depends test_user_can_login_with_good_credentials
     * @covers \App\Http\Controllers\API\Auth\AuthController::logout
     */
    public function test_user_can_logout(User $user)
    {
        $this->be($user);
        $this->assertAuthenticatedAs($user);
        $this->get('/logout');
        $this->assertGuest();
        $this->assertJson(json_encode(['success' => 'User logged out successfully']));
    }

    /**
     * @covers \App\Http\Controllers\API\Auth\AuthController::register
     */
    public function test_register()
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'test user pass'),
        ]);

        $response = $this->post('/register', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/');
    }

    protected function validate($mockedRequestData)
    {
        return $this->validator
            ->make($mockedRequestData, $this->rules)
            ->passes();
    }
}
