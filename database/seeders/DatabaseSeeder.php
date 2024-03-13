<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "id" => "007",
            "name" => "kiminonawa",
            "password" => bcrypt("password"),
            "role" => UserRole::ADMIN,
        ]);

        for ($i = 1; $i <= 6; $i++) {
            Classroom::create([
                "id" => "" . $i,
            ]);
        }
    }
}
