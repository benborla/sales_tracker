<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Repository\Eloquent\UserRepository;

class SecurityTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $response = $this->json('POST', '/api/login', [
            'email' => self::TEST_EMAIL,
            'password' => self::TEST_PASSWORD
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'email' => self::TEST_EMAIL
                ]
            ])
            ->assertJsonStructure([
                'token',
                'data'
            ]);
    }

    public function testLogout()
    {
        $response = $this->auth()->get('/api/logout');

        $response
            ->assertStatus(200)
            ->assertJson([
                'logout' => true
            ]);
    }

    public function testShouldMatchTheAuthenticatedInfo()
    {
        $response = $this->auth()->get('/api/me');

        $response
            ->assertStatus(200)
            ->assertJson([
                'email' => self::TEST_EMAIL
            ]);
    }
}
