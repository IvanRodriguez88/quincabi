<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProjectPaymentType;

class ProjectPaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProjectPaymentType::create([
            "name" => "Cash",
        ]);
        ProjectPaymentType::create([
            "name" => "Card",
        ]);
    }
}
