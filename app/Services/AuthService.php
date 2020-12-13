<?php


namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * @param array $data
     *  password string - Password<br/>
     *  email string - Email<br/>
     *  name string - User Name
     * @param string $role User Role
     * @return User
     */
    public function register(array $data, string $role = 'guest'): User
    {
        $data['password'] = Hash::make($data['password']);
        $user = User::query()->create($data);
        $user->assignRole($role);
        return $user;
    }
}
