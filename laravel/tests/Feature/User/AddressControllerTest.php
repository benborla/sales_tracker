<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User\Address;
use Symfony\Component\HttpFoundation\Response;

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

        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_create_shipping_address_for_user()
    {
        $user = $this->createUser();

        $payload = [
            'street' => 'Beatriz Village',
            'city' => 'Danao City',
            'state' => 'Cebu',
            'zipcode' => 6004,
            'country' => 'Philippines',
            'type' => Address::TYPE_SHIPPING
        ];

        $response = $this->api()->post("/api/users/{$user->id}/address", $payload);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_retrieve_user_specific_address()
    {
        $resource = $this->createAddress(Address::TYPE_SHIPPING);
        $userId = $resource['user']->id;
        $id = (int) $resource['id'];
        $response = $this->api()->get("/api/users/{$userId}/address/{$id}");

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_retrieve_user_billing_adddress()
    {
        $resource = $this->createAddress(Address::TYPE_BILLING);
        $userId = $resource['user']->id;
        $id = $resource['id'];
        $response = $this->api()->get("/api/users/{$userId}/billing");

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_retrieve_user_shipping_address()
    {
        $resource = $this->createAddress(Address::TYPE_SHIPPING);
        $userId = $resource['user']->id;
        $id = $resource['id'];
        $response = $this->api()->get("/api/users/{$userId}/shipping");

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_update_user_billing_address()
    {
        $resource = $this->createAddress(Address::TYPE_BILLING);
        $userId = $resource['user']->id;
        $id = $resource['id'];
        $matchZipcode = 6000;
        $matchCity = 'Cebu City';

        $payload = [
            'zipcode' => $matchZipcode,
            'city' => $matchCity
        ];

        $response = $this->api()->patch("/api/users/{$userId}/address/{$id}", $payload);
        
        $response->assertStatus(Response::HTTP_OK);
        $this->assertTrue( (int) $response['data']['zipcode'] === $matchZipcode);
        $this->assertTrue($response['data']['city'] === $matchCity);
    }

    public function test_delete_user_billing_address()
    {
        $resource = $this->createAddress(Address::TYPE_BILLING);
        $userId = $resource['user']->id;
        $id = $resource['id'];

        $response = $this->api()->deleteJson("/api/users/$userId/address/{$id}");
        $response->assertStatus(200);
        $this->assertTrue(true === $response['deleted']);

    }


    public function createAddress(string $type)
    {
        $user = $this->createUser();

        $payload = [
            'street' => 'Beatriz Village',
            'city' => 'Danao City',
            'state' => 'Cebu',
            'zipcode' => 6004,
            'country' => 'Philippines',
            'type' => $type
        ];

        $resource = $this->api()->post("/api/users/{$user->id}/address", $payload);
        return [
            'user' => $user,
            'id' => $resource['data']['id']
        ];
    }
}
