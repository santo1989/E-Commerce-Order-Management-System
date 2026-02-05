<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_and_login()
    {
        $payload = [
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $register = $this->postJson('/api/v1/auth/register', $payload);
        $register->assertStatus(201);

        $login = $this->postJson('/api/v1/auth/login', ['email' => 'user@example.com', 'password' => 'password']);
        $login->assertStatus(200)->assertJsonStructure(['access_token']);
    }
}
