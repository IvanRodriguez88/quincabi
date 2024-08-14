<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceRow extends Model
{
    use HasFactory;

	protected $table = 'invoice_rows';
	protected $fillable = ['invoice_id', 'material_id', 'extra_name', 'amount', 'unit_cost', 'unit_price', 'is_active', 'created_by', 'updated_by'];

	public function invoice()
    {
        return $this->belongsTo("App\Models\Invoice", "invoice_id", "id");
    }

    public function material()
    {
        return $this->belongsTo("App\Models\Material", "material_id", "id");
    }

}
