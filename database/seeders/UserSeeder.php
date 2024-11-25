<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
			'name' => 'Ivan',
			'email' => 'ivan@example.com',
			'password' => bcrypt('example')
		]);

        User::create([
			'name' => 'Eliezer',
			'email' => 'eliezer@quincabi.com',
			'password' => bcrypt('eliezer2024')
		]);
    }
}
