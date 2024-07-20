<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryMaterial extends Model
{
    use HasFactory;

    protected $table = 'category_material';
	protected $fillable = ['category_id', 'parent_category_material_id', 'category_item_id', 'material_id'];

    public function category()
    {
        return $this->belongsTo("App\Models\Category", "category_id", "id");
    }

    public function parent()
    {
        return $this->belongsTo("App\Models\CategoryMaterial", "parent_category_material_id", "id");
    }

    public function childs()
    {
        return $this->hasMany("App\Models\CategoryMaterial", 'parent_category_material_id');
    }

    public function categoryItem()
    {
        return $this->belongsTo("App\Models\CategoryItem", "category_item_id", "id");
    }

    public function material()
    {
        return $this->belongsTo("App\Models\CategoryMaterial", "material_id", "id");
    }
}
