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
        Schema::create('projects', function (Blueprint $table) {
			$table->id();

			$table->smallInteger('client_id')->unsigned();            
			$table->foreign('client_id')->references('id')->on('clients');

			$table->string("name")->comment("nombre del proyecto");
			$table->text("description")->comment("descripcion del proyecto");

			$table->float("cost_real")->nullable()->comment("cuanto costó al final");
			$table->float("total_real")->nullable()->comment("cuanto se cobró al final");

			$table->float("profit")->nullable()->comment("Total - costo - pago a trabajadores");

			$table->date('initial_date')->nullable()->comment('Fecha de inicio');
			$table->date('end_date')->nullable()->comment('Fecha de finalizacion');

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
        Schema::dropIfExists('projects');
    }
};
