<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

	protected $table = 'bills';
	protected $fillable = ['description', 'bill_type_id', 'project_payment_type_id', 'project_id', 'date', 'amount', 'is_active', 'created_by', 'updated_by'];

	public function billType()
    {
        return $this->belongsTo("App\Models\BillType", "bill_type_id", "id");
    }

    public function projectPaymentType()
    {
        return $this->belongsTo("App\Models\ProjectPaymentType", "project_payment_type_id", "id");
    }

    public function project()
    {
        return $this->belongsTo("App\Models\Project", "project_id", "id");
    }

}
