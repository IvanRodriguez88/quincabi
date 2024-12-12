<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		$categories = array(
			array('id' => '3','name' => 'PRIMO BLACK PLYWOOD','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-19 22:57:28','updated_at' => '2024-11-20 04:56:42'),
			array('id' => '4','name' => 'PLYWOOD','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-19 23:13:30','updated_at' => '2024-10-05 18:50:29'),
			array('id' => '5','name' => 'Hardwood','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-21 23:50:56','updated_at' => '2024-08-24 13:49:16'),
			array('id' => '6','name' => 'Hinges','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-22 00:41:39','updated_at' => '2024-11-11 01:01:36'),
			array('id' => '7','name' => 'Shelf Clips','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-22 00:56:27','updated_at' => '2024-08-22 00:58:21'),
			array('id' => '8','name' => 'Drawer Slides','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-24 13:42:24','updated_at' => '2024-10-25 00:43:48'),
			array('id' => '9','name' => 'Veneer','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-10-20 03:15:03','updated_at' => '2024-10-20 03:17:00'),
			array('id' => '10','name' => 'Edge Band','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-10-25 00:48:00','updated_at' => '2024-10-25 00:50:22'),
			array('id' => '11','name' => 'MDF','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-10-26 23:55:21','updated_at' => '2024-10-26 23:57:54')
		);

		foreach ($categories as $key => $category) {
			Category::create([
				"id" => $category["id"],
				"name" => $category["name"],
				"created_by" => $category["created_by"],
				"updated_by" => $category["updated_by"],
			]);
		}
    }
}
