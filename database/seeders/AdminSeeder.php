<?php

namespace Database\Seeders;

use App\Models\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            "id" => "007",
            "name" => "kiminonawa",
            "password" => bcrypt("password"),
            "role" => UserRole::ADMIN,
        ]);
    }
}
