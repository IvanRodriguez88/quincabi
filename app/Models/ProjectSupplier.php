<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectSupplier extends Model
{
    use HasFactory;

    protected $table = 'project_suppliers';
	protected $fillable = ['project_id', 'supplier_id', 'amount', 'is_active', 'created_by', 'updated_by'];

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    
    public function project()
    {
        return $this->belongsTo("App\Models\Invoice", "project", "id");
    }

    public function supplier()
    {
        return $this->belongsTo("App\Models\Supplier", "supplier_id", "id");
    }

}
