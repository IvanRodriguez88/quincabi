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
        Schema::create('project_workers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('worker_id')->constrained()->onDelete('cascade');

            $table->float("hourly_pay");
            $table->float("worked_hours")->default(0);

            $table->timestamp('created_at', 0)->useCurrent()->comment('Fecha de creación');
			$table->timestamp('updated_at', 0)->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->comment('Última fecha de modificación');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_workers');
    }
};
