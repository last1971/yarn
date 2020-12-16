<?php

namespace Database\Seeders;

use App\Services\AuthService;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(AuthService $service)
    {
        $admin = User::firstWhere('email', 'elcopro@gmail.com');
        if (!$admin) {
            $admin = $service->register(
                [
                    'name' => 'Valdimir',
                    'email' => 'elcopro@gmail.com',
                    'password' => '123456',
                ],
                'admin'
            );
        }
    }
}
