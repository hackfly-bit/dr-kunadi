<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthTest extends TestCase
{
    use RefreshDatabase; // This will refresh the database before each test

    public function test_a_user_can_register(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'abc@mail.com',
            'password' => 'password' // Ensure this gets hashed inside the register controller
        ]);

        // Assert the response status is 200 (successful registration)
        $response->assertStatus(200);

        // Optionally, assert that the user was actually created in the database
        $this->assertDatabaseHas('users', [
            'email' => 'abc@mail.com',
        ]);
    }

    public function test_a_user_can_login(): void
    {
        // Create a user manually for this test
        $user = User::factory()->create([
            'email' => 'abc@mail.com',
            'password' => Hash::make('password') // Password must be hashed in the database
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password' // Plain password (since it's compared in login)
        ]);

        // Assert that login was successful
        $response->assertStatus(200);

        // Optionally, you can also assert that the token was returned in the response
        $response->assertJsonStructure([
            'access_token',
        ]);
    }

    public function test_a_user_can_logout(): void
    {
        // Create and authenticate a user
        $user = User::factory()->create();

        // Create a token for this user to simulate login
        $token = $user->createToken('auth_token')->plainTextToken;

        // Make a logout request with the Bearer token in the headers
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/logout');

        // Assert that the logout was successful
        $response->assertStatus(200);

        // Optionally, assert the user's tokens have been deleted
        $this->assertCount(0, $user->tokens);
    }
}
