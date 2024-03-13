<?php

namespace App\Services;

use App\Models\Enums\UserRole;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserService
{

    public function signUp(string $id, string $password, string $role, string $name): User
    {
        $user = User::query()->find($id);
        if ($user != null) {
            throw new HttpException(403, "FORBIDDEN");
        }

        return User::create([
            "id" => $id,
            "password" => bcrypt($password),
            "role" => UserRole::from($role),
            "name" => UserRole::from($name),
        ]);
    }
}
