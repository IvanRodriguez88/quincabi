<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CategoryItem;

class CategoryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoryItem::create([
			'category_id' => 1,
			'name' => 'Colores', 
			'order' => 1
		]);
		CategoryItem::create([
			'category_id' => 1,
			'name' => 'Medidas', 
			'order' => 2
		]);

		CategoryItem::create([
			'category_id' => 1,
			'category_item_id' => 1,
			'name' => 'Rojo'
		]);

		CategoryItem::create([
			'category_id' => 1,
			'category_item_id' => 1, 
			'name' => 'Azul', 
		]);
		CategoryItem::create([
			'category_id' => 1,
			'category_item_id' => 1, 
			'name' => 'Verde', 
		]);

		CategoryItem::create([
			'category_id' => 1,
			'category_item_id' => 2, 
			'name' => 'Mediano', 
		]);
		CategoryItem::create([
			'category_id' => 1,
			'category_item_id' => 2, 
			'name' => 'Grande', 
		]);
    }
}
