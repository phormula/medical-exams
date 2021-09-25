<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registers_a_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/api/register',[
                'name' => 'Evans',
                'email' => 'structure123@gmail.com',
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
                'user',
                'token' ,
            ]);
    }

    public function test_loggedin_a_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/api/login',[
                'email' => 'structure1@gmail.com',
                'password' => 'password',
            ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
                'user',
                'token' ,
            ]);
    }
}
