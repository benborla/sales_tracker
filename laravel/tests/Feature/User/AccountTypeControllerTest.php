<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountTypeControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_users_account_type()
    {
        $user = $this->createUser();

        $response = $this->api()->get("/api/users/{$user->id}/account_type");

        $response->assertStatus(200);
    }
}
