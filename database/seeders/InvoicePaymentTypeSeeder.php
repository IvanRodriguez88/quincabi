<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InvoicePaymentType;

class InvoicePaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InvoicePaymentType::create([
            "name" => "Cash",
        ]);
        InvoicePaymentType::create([
            "name" => "Card",
        ]);
    }
}
