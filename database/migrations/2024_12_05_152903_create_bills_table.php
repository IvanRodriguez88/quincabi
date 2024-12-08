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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();

            $table->string("description")->comment("descripcion del gasto");
			
            $table->smallInteger('bill_type_id')->unsigned();            
			$table->foreign('bill_type_id')->references('id')->on('bill_types');

            $table->bigInteger('project_payment_type_id')->unsigned();            
			$table->foreign('project_payment_type_id')->references('id')->on('project_payment_types');

            $table->bigInteger('project_id')->nullable()->unsigned();            
			$table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');

			$table->date('date')->nullable()->comment('Fecha del gasto');
			$table->float('amount')->comment('gasto');



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
        Schema::dropIfExists('bills');
    }
};