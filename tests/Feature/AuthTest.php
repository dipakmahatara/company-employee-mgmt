<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_access_companies(): void
    {
        $response = $this->getJson('/api/companies');
        $response->assertStatus(401);
    }

    public function test_unauthenticated_user_cannot_access_employees(): void
    {
        $response = $this->getJson('/api/employees');
        $response->assertStatus(401);
    }

    public function test_login_with_correct_credentials(): void
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'token',
        ]);
    }

    public function test_login_with_incorrect_credentials(): void
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'abcdefgh'
        ]);

        $response->assertUnauthorized()->assertJson([
            'message' => 'These credentials do not match our records'
        ]);;
    }
}
