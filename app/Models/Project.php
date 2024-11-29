<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';
	protected $fillable = ['client_id', 'name', 'description', 'initial_date', 'end_date', 'cost_real', 'total_real', 'profit', 'is_active', 'created_by', 'updated_by'];

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
                    ->withPivot('id', 'hourly_pay', 'worked_hours')
                    ->withTimestamps();
    }

    public function payments()
    {
        return $this->hasMany("App\Models\ProjectPayment");
    }

    public function getTotalPayments()
    {
        $total = 0;
		foreach ($this->payments as $payment) {
			$total += $payment->amount;
		};

		return $total;
    }



}
