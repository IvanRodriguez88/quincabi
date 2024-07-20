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
        Schema::create('category_items', function (Blueprint $table) {
            $table->id();

            $table->smallInteger('category_id')->unsigned();            
			$table->foreign('category_id')->references('id')->on('categories')->onDelete("cascade");

			$table->bigInteger('category_item_id')
				->unsigned()
				->nullable()
				->comment('Id del item o subcategoría (si es nulo es nombre de subcategoría)');            
			$table->foreign('category_item_id')->references('id')->on('category_items')->onDelete("cascade");

			$table->string('name')->comment('Nombre de la subcategoría o del item');

			$table->smallInteger('order')
				->unsigned()
				->nullable()
				->comment('Orden de la subcategoría (solo cuando es null el category_item_id)');

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
        Schema::dropIfExists('category_items');
    }
};
