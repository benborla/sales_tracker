<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User\Address;

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

    public function test_create_billing_address_for_user()
    {
        $user = $this->createUser();

        $payload = [
            'street' => 'Beatriz Village',
            'city' => 'Danao City',
            'state' => 'Cebu',
            'zipcode' => 6004,
            'country' => 'Philippines',
            'type' => Address::TYPE_BILLING
        ];

        $response = $this->api()->post("/api/users/{$user->id}/address", $payload);

        $response->dump();

    }
}
