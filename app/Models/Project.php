<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';
	protected $fillable = ['client_id', 'name', 'description', 'initial_date', 'end_date', 'cost_real', 'total_real', 'profit', 'is_active', 'created_by', 'updated_by'];
    protected $appends = ['total_bills','total_invoice_prices','total_invoice_costs','total_payments', 'total_suppliers', 'rest_payments', 'total_worked_hours', 'total_payments_workers', 'average_payment_per_hour', 'total_cost'];
	
    public function client()
    {
        return $this->belongsTo("App\Models\Client", "client_id", "id");
    }

    public function invoices()
    {
        return $this->hasMany("App\Models\Invoice");
    }

    public function workers()
    {
        return $this->belongsToMany(Worker::class, 'project_workers')
                    ->withPivot('id', 'hourly_pay', 'worked_hours', 'date')
                    ->withTimestamps();
    }

	public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'project_suppliers')
                    ->withPivot('id', 'amount')
                    ->withTimestamps();
    }

	public function partners()
    {
        return $this->belongsToMany(Partner::class, 'project_partners')
                    ->withPivot('id', 'percentage', 'amount')
                    ->withTimestamps();
    }

    public function payments()
    {
        return $this->hasMany("App\Models\ProjectPayment");
    }

	public function bills()
    {
        return $this->hasMany("App\Models\Bill");
    }

    public function projectPictures()
    {
        return $this->hasMany("App\Models\ProjectPicture");
    }

	public function projectTickets()
    {
        return $this->hasMany("App\Models\ProjectTicket");
    }

	public function getTotalGains()
	{
		return $this->total_real - $this->cost_real;
	}

	public function getPartnersGain()
	{
		$percentagesSum = 0;
		foreach ($this->partners as $key => $partner) {
			$percentagesSum += $partner->pivot->percentage;
		}
		return ($this->getTotalGains() * $percentagesSum) / 100;
		
	}

	public function getProfit()
	{
		return $this->getTotalGains() - $this->getPartnersGain();
	}

	public function totalInvoicesPrices()
	{
		$total = 0;
		$invoicesInUse = $this->invoices()->where("in_use", 1)->get();
		foreach ($invoicesInUse as $invoice) {
			$total += $invoice->getTotal();
		}
		return $total;
	}

	public function totalInvoicesCosts()
	{
		$total = 0;
		$invoicesInUse = $this->invoices()->where("in_use", 1)->get();
		foreach ($invoicesInUse as $invoice) {
			$total += $invoice->getCost();
		}
		return $total;
	}

	public function getTotalCostAttribute()
	{
		return $this->total_bills + $this->total_payments_workers + $this->total_suppliers;
	}

	public function getTotalInvoiceCostsAttribute()
	{
		return $this->totalInvoicesCosts();
	}

	public function getTotalInvoicePricesAttribute()
	{
		return $this->totalInvoicesPrices();
		
	}


	// Accessor para total_payments
	public function getTotalPaymentsAttribute()
	{
		return $this->payments->sum('amount');
	}

	// Accessor para total_payments
	public function getTotalBillsAttribute()
	{
		return $this->bills->sum('amount');
	}


	// Accessor para total_payments_workers
	public function getTotalSuppliersAttribute()
	{
		$total_payments = 0;
		foreach ($this->suppliers as $supplier) {
			$total_payments += $supplier->pivot->amount;
		}
		return $total_payments;
	}

	// Accessor para rest_payments
	public function getRestPaymentsAttribute()
	{
		return $this->totalInvoicesPrices() - $this->payments->sum('amount');
		
	}

	// Accessor para total_worked_hours
	public function getTotalWorkedHoursAttribute()
	{
		$total_hours = 0;
		foreach ($this->workers as $worker) {
			$total_hours += $worker->pivot->worked_hours;
		}
		return $total_hours;
	}

	// Accessor para total_payments_workers
	public function getTotalPaymentsWorkersAttribute()
	{
		$total_payments = 0;
		foreach ($this->workers as $worker) {
			$total_payments += $worker->pivot->worked_hours * $worker->pivot->hourly_pay;
		}
		return $total_payments;
	}

	// Accessor para average_payment_per_hour
	public function getAveragePaymentPerHourAttribute()
	{
		$totalWorkedHours = $this->getTotalWorkedHoursAttribute() == 0 ? 1 : $this->getTotalWorkedHoursAttribute();
		return $this->getTotalPaymentsWorkersAttribute() / $totalWorkedHours;
	}



}
