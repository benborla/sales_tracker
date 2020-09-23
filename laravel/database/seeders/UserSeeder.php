<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'           => 'Super Admin',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'email'          => 'admin@test.com',
            'password'       => bcrypt('admin123'),
            'remember_token' => Str::random(60)
        ]);

        User::factory()
            ->times(50)
            ->create();
    }
}
