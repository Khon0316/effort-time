<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * A User Login
     *
     * @return void
     */
    public function testUserLoginAPI()
    {
        $this->withoutExceptionHandling();

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->password,
            'password_confirmation' => $this->faker->password,
        ];

        $response = $this->get('/airlock/csrf-cookie');

        $response->assertStatus(Response::HTTP_NO_CONTENT);

    }

    public function testUserRegisterAPI()
    {
        $this->withoutExceptionHandling();

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->password,
            'password_confirmation' => $this->faker->password,
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
