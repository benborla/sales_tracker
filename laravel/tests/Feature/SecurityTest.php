<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Repository\Eloquent\UserRepository;
use Laravel\Sanctum\Sanctum;
use App\Models\User;


class SecurityTest extends TestCase
{

    /**
     * @test
     */
    public function test_login()
    {
        $user = $this->createUser();
        $response = $this->json('POST', '/api/login', [
            'email' => $user->email,
            'password' => self::TEST_PASSWORD
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'email' => $user->email
                ]
            ])
            ->assertJsonStructure([
                'token',
                'data'
            ]);

        $user->tokens()->delete();
    }

    public function test_logout()
    {
        $response = $this->api()->getJson('/api/logout');

        $response
            ->assertStatus(200)
            ->assertJson([
                'logout' => true
            ]);
    }

    public function testShouldMatchTheAuthenticatedInfo()
    {
        $user = $this->createUser();
        $response = $this->api($user)->get('/api/me');

        $response
            ->assertStatus(200)
            ->assertJson([
                'email' => $user->email
            ]);
    }
}
