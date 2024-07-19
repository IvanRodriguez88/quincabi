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
        Schema::create('invoice_rows', function (Blueprint $table) {
            $table->id();

			$table->bigInteger('invoice_id')->unsigned();            
			$table->foreign('invoice_id')->references('id')->on('invoices');

			$table->bigInteger('material_id')
				->unsigned()
				->nullable()
				->comment('Si es nulo es porque se agregó un row sin existencia en materials');          
			$table->foreign('material_id')->references('id')->on('materials');

			$table->string('extra_name')
				->nullable()
				->comment('Nombre del material o producto creado en el momento (sin registro en la bd)');

			$table->smallInteger('amount')->unsigned();
			$table->float('unit_cost')->comment('Costo al momento de vender');
			$table->float('unit_price')->comment('Precio al momento de vender (puede ser diferente del registro en materials)');

			//Datos de creación y modificación
			$table->string('notes', 1024)->nullable()->comment('Notas');
			$table->boolean('is_active')->default(1)->comment('Muestra si la fila está activa');
			$table->smallInteger('created_by')->unsigned()->nullable()->comment('Usuario que creó');
			$table->foreign('created_by')->references('id')->on('users');
			$table->smallInteger('updated_by')->unsigned()->nullable()->comment('Último usuario que modificó');
			$table->foreign('updated_by')->references('id')->on('users');
			$table->timestamp('created_at', 0)->useCurrent()->comment('Fecha de creación');
			$table->timestamp('updated_at', 0)->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->comment('Última fecha de modificación');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_rows');
    }
};
