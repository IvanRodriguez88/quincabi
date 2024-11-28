<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';
	protected $fillable = ['name', 'project_id', 'client_id',  'date_issued', 'date_due', 'is_active', 'created_by', 'updated_by'];

    public function client()
    {
        return $this->belongsTo("App\Models\Client", "client_id", "id");
    }

	public function project()
    {
        return $this->belongsTo("App\Models\Project", "project_id", "id");
    }

    public function invoiceRows()
    {
		return $this->hasMany('App\Models\InvoiceRow');
    }

	public function getTotal()
	{
		$total = 0;
		foreach ($this->invoiceRows as $invoiceRow) {
			$total += $invoiceRow->amount * $invoiceRow->unit_price;
		};

		return $total;
	}

	public function getCost()
	{
		$cost = 0;
		foreach ($this->invoiceRows as $invoiceRow) {
			$cost += $invoiceRow->amount * $invoiceRow->unit_cost;
		};

		return $cost;
	}
}
