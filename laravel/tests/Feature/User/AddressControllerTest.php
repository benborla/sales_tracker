<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddressControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_users_addresses()
    {
        $user = $this->createUser();

        $response = $this->api()->get("/api/users/{$user->id}/address");

        $response->assertStatus(200);
    }
}
