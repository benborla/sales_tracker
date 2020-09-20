<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use App\Repository\UserRepositoryInterface;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected const TEST_EMAIL = 'admin@test.com';
    protected const TEST_PASSWORD = 'admin123';

    protected $userRepository;

    public function setUp(): void
    {
        parent::setUp();
    }

    protected function createUser()
    {
        return User::factory()->make();
    }

    protected function auth()
    {
        $response = $this->json('POST', '/api/login', [
            'email' => self::TEST_EMAIL,
            'password' => self::TEST_PASSWORD
        ]);

        return $this->withHeaders([
            'Authorization' => "Bearer $response[token]"
        ]);
    }
}
