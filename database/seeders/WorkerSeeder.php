<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Worker;

class WorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		
		Worker::create([
			"name" => "Juan Perez",
			'hourly_pay' => 10,
		]);

		Worker::create([
			"name" => "Emiliano Zapata",
			'hourly_pay' => 12,
		]);

		Worker::create([
			"name" => "Lizet Arriaga",
			'hourly_pay' => 14,
		]);
    }
}
