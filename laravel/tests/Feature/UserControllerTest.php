<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Repository\Eloquent\UserRepository;

class UserControllerTest extends TestCase
{
    public function test_get_users_collection()
    {
        $response = $this->api()->get('/api/users');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'links',
                'meta'
            ]);
    }

    public function test_get_user()
    {
        $user = $this->createUser();
        $response = $this->api()->getJson("/api/users/$user->id");

        $response->assertStatus(200);
        $this->assertTrue($user->email === $response['data']['email']);
        $this->assertTrue($response['data']['id'] === $user->id);
    }

    public function test_create_user()
    {
        $email = \uniqid() . '@example.com';
        $response = $this->api()->postJson('/api/users', [
            'email' => $email,
            'name' => 'Feature Test',
            'password' => self::TEST_PASSWORD
        ]);

        $response->assertStatus(201);
        $this->assertTrue($email == $response['data']['email']);
    }

    public function test_update_user()
    {
        $newName = 'Ben Franklin';
        $user = $this->createUser();

        $response = $this->api()->patchJson("/api/users/$user->id", ['name' => $newName]);

        $response->assertStatus(200);
        $this->assertTrue($newName === $response['data']['name']);
    }

    public function test_delete_user()
    {
        $user = $this->createUser();

        $response = $this->api()->deleteJson("/api/users/$user->id");
        $response->assertStatus(200);
        $this->assertTrue(true === $response['deleted']);
    }
}
