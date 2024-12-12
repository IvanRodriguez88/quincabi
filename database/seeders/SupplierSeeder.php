<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		$suppliers = array(
			array('id' => '1','name' => 'Dakota Hardwoods','address' => '5910 W By Northwest Blvd. Houston, Tx 77040','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-19 22:50:10','updated_at' => '2024-08-19 22:50:10'),
			array('id' => '2','name' => 'Gonzales Products','address' => '7204 Boyce st. Houston, Tx 77020','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-19 22:50:30','updated_at' => '2024-08-19 22:50:30'),
			array('id' => '3','name' => 'Hardwood Products','address' => '1585 W Sam Houston Pkwy. Houston, Tx 77043','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-19 22:52:07','updated_at' => '2024-08-19 22:52:07'),
			array('id' => '4','name' => '3L Moulding','address' => '1518 Austin St. South Houston, Tx 77587','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-19 22:52:56','updated_at' => '2024-08-19 22:52:56'),
			array('id' => '5','name' => 'Texas Wood Supply','address' => '3485 W 12th st. Houston, Tx 77008','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-19 22:54:10','updated_at' => '2024-08-19 22:54:10'),
			array('id' => '6','name' => 'Wurth Lois & company','address' => '551 Garden Oaks Blvd, Houston, TX 77018','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-22 00:55:27','updated_at' => '2024-08-22 00:55:27')
		);

		foreach ($suppliers as $key => $supplier) {
			Supplier::create([
				"id" => $supplier["id"],
				"name" => $supplier["name"],
				"address" => $supplier["address"],
				"created_by" => $supplier["created_by"],
				"updated_by" => $supplier["updated_by"],
	
			]);
		}
    }
}
