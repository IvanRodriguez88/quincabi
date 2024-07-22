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
			$table->foreign('parent_category_material_id')->references('id')->on('category_material')->onDelete("cascade");

			$table->bigInteger('category_item_id')
				->unsigned()
				->nullable()
				->comment('Id del item (no debe ser de subcategoría)');            
			$table->foreign('category_item_id')->references('id')->on('category_items');

			$table->bigInteger('material_id')
				->unsigned()
				->comment('Id del material');            
			$table->foreign('material_id')->references('id')->on('materials')->onDelete("cascade");

			//Datos de creación y modificación
			$table->timestamp('created_at', 0)->useCurrent()->comment('Fecha de creación');
			$table->timestamp('updated_at', 0)->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->comment('Última fecha de modificación');
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
