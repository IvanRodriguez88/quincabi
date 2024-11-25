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
        $material = Material::create([
            'supplier_id' => 1,
			'name'  => "Madera Rojo Mediano", 
			'extra_name'  => 1, 
			'cost'  => 1, 
			'price'  => 1, 
        ]);

		CategoryMaterial::create([
            'category_id' => 1,
			'parent_category_material_id'  => null, 
			'category_item_id'  => null, 
			'material_id'  => 1, 
        ]);

		CategoryMaterial::create([
            'category_id' => 1,
			'parent_category_material_id'  => 1, 
			'category_item_id'  => 3, 
			'material_id'  => 1, 
        ]);

		CategoryMaterial::create([
            'category_id' => 1,
			'parent_category_material_id'  => 2, 
			'category_item_id'  => 6, 
			'material_id'  => 1, 
        ]);
    }
}
