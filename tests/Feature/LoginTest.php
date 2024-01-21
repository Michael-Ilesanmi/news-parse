<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testValidCredentials()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@email.com',
            'password' => 'password123'
        ]);
    
        $response = $this->actingAs($user, 'web')
            ->post('/login', [
                'email' => 'test@email.com',
                'password' => 'password123',
            ]);
    
        $response->assertRedirect('/');
        $this->assertAuthenticated();
    }

    public function testInvalidCredentials()
    {
        $response = $this->post('/login', [
            'email' => 'invalid@example.com',
            'password' => 'invalidpassword',
        ]);

        $response->assertRedirect('/');    
        $response->assertSessionHasErrors(['email' => 'The provided credentials do not match our records.']);
    }
}

