<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Material;
use App\Models\CategoryMaterial;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		$materials = array(
			array('id' => '2','supplier_id' => '1','name' => 'PLYWOOD 3/4” White Oak B-2 VC 4’ x 8’','extra_name' => NULL,'cost' => '100.60','price' => '110.00','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-21 23:40:47','updated_at' => '2024-08-21 23:40:47'),
			array('id' => '3','supplier_id' => '1','name' => 'PRIMO BLACK PLYWOOD C+ White Birch VC 18mm x 4 x 8','extra_name' => NULL,'cost' => '46.55','price' => '55.00','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-21 23:46:02','updated_at' => '2024-08-21 23:46:02'),
			array('id' => '4','supplier_id' => '1','name' => 'PRIMO BLACK PLYWOOD C+ White Birch VC 12mm x 4 x 8','extra_name' => NULL,'cost' => '35.16','price' => '42.00','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-21 23:48:52','updated_at' => '2024-08-21 23:48:52'),
			array('id' => '5','supplier_id' => '1','name' => 'PLYWOOD 1/4” Birch C-2 MDFC 4’ x 8’','extra_name' => NULL,'cost' => '27.07','price' => '35.00','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-21 23:50:33','updated_at' => '2024-08-21 23:50:33'),
			array('id' => '6','supplier_id' => '1','name' => 'HARDWOOD LUMBER Poplar FAS 4/4','extra_name' => NULL,'cost' => '2.52','price' => '3.20','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-22 00:40:28','updated_at' => '2024-08-22 00:40:28'),
			array('id' => '7','supplier_id' => '6','name' => 'Hinges BLUM CLIPTOP Frame Soft close','extra_name' => NULL,'cost' => '3.59','price' => '5.00','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-22 00:54:25','updated_at' => '2024-08-24 13:38:52'),
			array('id' => '8','supplier_id' => '1','name' => 'Shelf Clips 1/4 L-shape Nickel','extra_name' => NULL,'cost' => '0.15','price' => '0.18','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-22 00:59:28','updated_at' => '2024-08-22 00:59:28'),
			array('id' => '9','supplier_id' => '1','name' => 'Hardwood App White Oak FAS 4/4','extra_name' => NULL,'cost' => '9.82','price' => '12.00','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-22 01:16:54','updated_at' => '2024-08-22 01:16:54'),
			array('id' => '10','supplier_id' => '4','name' => 'PLYWOOD 3/4” Birch C-2 VC 4’ x 8’','extra_name' => NULL,'cost' => '38.43','price' => '45.00','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-10-05 18:51:28','updated_at' => '2024-10-05 18:51:28'),
			array('id' => '11','supplier_id' => '4','name' => 'PLYWOOD 1/4” Birch C-2 VC 4’ x 8’','extra_name' => NULL,'cost' => '18.95','price' => '25.00','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-10-05 18:52:40','updated_at' => '2024-10-05 18:52:40'),
			array('id' => '12','supplier_id' => '1','name' => 'PLYWOOD 1/2” White Oak B-2 VC 4’ x 8’','extra_name' => NULL,'cost' => '106.97','price' => '120.00','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-10-20 03:13:36','updated_at' => '2024-10-20 03:13:36'),
			array('id' => '13','supplier_id' => '1','name' => 'Veneer Birch 48" x 96"','extra_name' => NULL,'cost' => '80.02','price' => '95.00','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-10-20 03:18:11','updated_at' => '2024-10-20 03:18:11'),
			array('id' => '14','supplier_id' => '1','name' => 'PLYWOOD 1/4” White Oak B-2 MDFC 4’ x 8’','extra_name' => NULL,'cost' => '64.23','price' => '75.00','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-10-20 03:21:03','updated_at' => '2024-10-20 03:21:03'),
			array('id' => '15','supplier_id' => '1','name' => 'Drawer Slides Blum 21" Undermount','extra_name' => NULL,'cost' => '25.39','price' => '30.00','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-10-20 04:26:14','updated_at' => '2024-10-20 04:26:14'),
			array('id' => '16','supplier_id' => '1','name' => 'PLYWOOD 1/2” Birch C-2 VC 4’ x 8’','extra_name' => NULL,'cost' => '35.16','price' => '45.00','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-10-25 00:29:08','updated_at' => '2024-10-25 00:29:08'),
			array('id' => '17','supplier_id' => '1','name' => 'Drawer Slides Pro 21" Undermount','extra_name' => NULL,'cost' => '14.00','price' => '20.00','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-10-25 00:42:47','updated_at' => '2024-10-25 00:42:47'),
			array('id' => '18','supplier_id' => '1','name' => 'Drawer Slides Pro 21" Side-Mount','extra_name' => NULL,'cost' => '10.10','price' => '15.00','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-10-25 00:44:41','updated_at' => '2024-10-25 00:44:41'),
			array('id' => '19','supplier_id' => '1','name' => 'Edge Band Birch 1" Auto','extra_name' => NULL,'cost' => '30.90','price' => '38.00','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-10-25 00:51:20','updated_at' => '2024-10-25 00:51:20'),
			array('id' => '20','supplier_id' => '1','name' => 'MDF 3/4" 4\'x8\'','extra_name' => NULL,'cost' => '40.00','price' => '48.00','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-10-26 23:59:01','updated_at' => '2024-10-26 23:59:01'),
			array('id' => '21','supplier_id' => '1','name' => 'Hinges L-susan Frame Regular','extra_name' => NULL,'cost' => '13.00','price' => '18.00','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-11-11 01:02:35','updated_at' => '2024-11-11 01:02:35'),
			array('id' => '22','supplier_id' => '1','name' => 'PRIMO BLACK PLYWOOD C+ White Birch VC 12mm x 4 x 8','extra_name' => NULL,'cost' => '35.16','price' => '45.00','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-11-16 02:35:44','updated_at' => '2024-11-16 02:35:44'),
			array('id' => '23','supplier_id' => '1','name' => 'PRIMO BLACK PLYWOOD C+ White Birch VC UV 1-Side 18mm x 4 x 8','extra_name' => NULL,'cost' => '44.40','price' => '55.00','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-11-20 04:54:01','updated_at' => '2024-11-20 04:54:01'),
			array('id' => '24','supplier_id' => '1','name' => 'PRIMO BLACK PLYWOOD C+ White Birch VC UV 2-Side 18mm x 4 x 8','extra_name' => NULL,'cost' => '51.33','price' => '60.00','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-11-20 04:54:52','updated_at' => '2024-11-20 04:54:52'),
			array('id' => '25','supplier_id' => '1','name' => 'PRIMO BLACK PLYWOOD C+ White Birch VC UV 2-Side 12mm x 4 x 8','extra_name' => NULL,'cost' => '35.30','price' => '42.00','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-11-20 04:55:44','updated_at' => '2024-11-20 04:55:44'),
			array('id' => '26','supplier_id' => '1','name' => 'PRIMO BLACK PLYWOOD C+ White Birch VC UV 1-Side 5.2mm x 4 x 8','extra_name' => NULL,'cost' => '21.30','price' => '30.00','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-11-20 04:57:13','updated_at' => '2024-11-20 04:57:13')
		  );

        foreach ($materials as $key => $material) {
			Material::create([
				"id" => $material["id"],
				"supplier_id" => $material["supplier_id"],
				"name" => $material["name"],
				"extra_name" => $material["extra_name"],
				"cost" => $material["cost"],
				"cost" => $material["cost"],
				"price" => $material["price"],
				"created_by" => $material["created_by"],
				"updated_by" => $material["updated_by"],
			]);
		}
    }
}
