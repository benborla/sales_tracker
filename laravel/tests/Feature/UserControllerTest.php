<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Repository\Eloquent\UserRepository;

class UserControllerTest extends TestCase
{
    private function getUserRepository()
    {
        return new UserRepository(new User());
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_users_collection()
    {
        $response = $this->auth()->get('/api/users');

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
        $user = $this->getUserRepository()->getOneBy('email', self::TEST_EMAIL);
        $response = $this->auth()->get("/api/users/$user->id");

        $response->assertStatus(200);
        $this->assertTrue($user->email === $response['data']['email']);
        $this->assertTrue($response['data']['id'] === $user->id);
    }

    public function test_create_user()
    {

        $request = $this->userRequest();
        $response = $this->auth()->postJson('/api/users', $request);

        $response->assertStatus(201);
        $this->assertTrue($request['email'] === $response['data']['email']);
    }

    public function test_update_user()
    {
        $newName = 'Ben Franklin';

        $createdUser = $this->auth()->postJson('/api/users', $this->userRequest());
        $id = $createdUser['data']['id'];

        $response = $this->auth()->patchJson("/api/users/$id", ['name' => $newName]);

        $response->assertStatus(200);
        $this->assertTrue($newName === $response['data']['name']);
    }

    public function test_delete_user()
    {
        $createdUser = $this->auth()->postJson('/api/users', $this->userRequest());
        $id = $createdUser['data']['id'];

        $response = $this->auth()->deleteJson("/api/users/$id");
        $response->assertStatus(200);
        $this->assertTrue(true === $response['deleted']);
    }

    private function userRequest()
    {
        $user = $this->createUser();
        return [
            'email' => $user->email,
            'name' => $user->name,
            'password' => 'test123'
        ];
    }
}
