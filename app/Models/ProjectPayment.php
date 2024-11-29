<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPayment extends Model
{
    use HasFactory;

    protected $table = 'project_payments';
	protected $fillable = ['project_id', 'project_payment_type_id', 'date', 'amount', 'is_active', 'created_by', 'updated_by'];

    public function project()
    {
        return $this->belongsTo("App\Models\Invoice", "project", "id");
    }

    public function projectPaymentType()
    {
        return $this->belongsTo("App\Models\ProjectPaymentType", "project_payment_type_id", "id");
    }

}
