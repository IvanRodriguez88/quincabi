<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('category_material', function (Blueprint $table) {
            $table->id();

			$table->smallInteger('category_id')->unsigned();            
			$table->foreign('category_id')->references('id')->on('categories');

			$table->bigInteger('parent_category_material_id')
				->unsigned()
				->nullable()
				->comment('Si es nulo es el primer nivel (es para revisar la cadena de categorías del material)');           
			$table->foreign('parent_category_material_id')->references('id')->on('category_material');

			$table->bigInteger('category_item_id')
				->unsigned()
				->comment('Id del item (no debe ser de subcategoría)');            
			$table->foreign('category_item_id')->references('id')->on('category_items');

			$table->bigInteger('material_id')
				->unsigned()
				->comment('Id del material');            
			$table->foreign('material_id')->references('id')->on('materials');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_material');
    }
};
