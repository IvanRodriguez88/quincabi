<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $table = 'materials';
	protected $fillable = ['supplier_id', 'name', 'extra_name', 'cost', 'price', 'is_active', 'created_by', 'updated_by'];

    public function supplier()
    {
        return $this->belongsTo("App\Models\Supplier", "supplier_id", "id");
    }

    public function categoryMaterials()
    {
        return $this->hasMany("App\Models\CategoryMaterial");
    }
}
