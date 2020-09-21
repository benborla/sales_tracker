<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use App\Repository\UserRepositoryInterface;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected const TEST_PASSWORD = 'secret';

    protected $userRepository;

    public function setUp(): void
    {
        parent::setUp();
    }

    protected function createUser()
    {
        return User::factory()->create(['password' => bcrypt(self::TEST_PASSWORD)]);
    }

    protected function api(?User $user = null)
    {
        $user = $user ?? $this->createUser();
        $token = $user->createToken($user->email)->plainTextToken;

        return $this->withHeaders(['Authorization' => "Bearer $token"]);
    }
}
