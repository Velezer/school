<?php

namespace Database\Seeders;

use App\Models\Period;
use Illuminate\Database\Seeder;

class PeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Period::create([
            "id" => "2023/2024",
        ]);
        Period::create([
            "id" => "2024/2025",
        ]);
    }
}
