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
        Schema::table('workers', function (Blueprint $table) {
            $table->decimal('hourly_pay', 13, 4)->change(); 
        });
        Schema::table('materials', function (Blueprint $table) {
            $table->decimal('cost', 13, 4)->change(); 
            $table->decimal('price', 13, 4)->change(); 
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->decimal('cost_real', 13, 4)->change(); 
            $table->decimal('total_real', 13, 4)->change(); 
            $table->decimal('profit', 13, 4)->change(); 
        });

        Schema::table('invoice_rows', function (Blueprint $table) {
            $table->decimal('unit_cost', 13, 4)->change(); 
            $table->decimal('unit_price', 13, 4)->change(); 
        });

        Schema::table('project_payments', function (Blueprint $table) {
            $table->decimal('amount', 13, 4)->change(); 
        });

        Schema::table('project_workers', function (Blueprint $table) {
            $table->decimal('hourly_pay', 13, 4)->change(); 
            $table->decimal('worked_hours', 13, 4)->change(); 
        });

        Schema::table('bills', function (Blueprint $table) {
            $table->decimal('amount', 13, 4)->change(); 
        });

        Schema::table('partners', function (Blueprint $table) {
            $table->decimal('percentage', 13, 4)->change(); 
        });

        Schema::table('project_partners', function (Blueprint $table) {
            $table->decimal('percentage', 13, 4)->change(); 
            $table->decimal('amount', 13, 4)->change(); 
        });
    }

};
