<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test User Password
     * @var string
     */
    private string $password = 'password';

    /**
     * A User Login
     *
     * @return void
     */
    public function testUserLoginAPI()
    {
//        $this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'password' => Hash::make($this->password),
        ]);

        $response = $this->get('/airlock/csrf-cookie');

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $response = $this->post('/api/v1/login', [
            'email' => $user->email,
            'password' => $this->password,
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['user']);

    }

    /**
     * Create User register
     * @return void
     */
    public function testUserRegisterAPI()
    {
//        $this->withoutExceptionHandling();

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->password,
            'password_confirmation' => $this->password,
        ];

        $response = $this->post('/api/v1/register', $data);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(['user']);

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }
}
