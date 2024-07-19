<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

	protected $table = 'categories';
	protected $fillable = ['name', 'notes', 'is_active', 'created_by', 'updated_by', 'created_at', 'updated_at'];

	public function subcategories()
	{
		return $this->hasMany('App\Models\CategoryItem')->where('category_item_id', null)->orderBy('order', 'asc');
	}

	public function categoryItems()
	{
		return $this->hasMany('App\Models\CategoryItem')->whereNotNull('category_item_id');
	}

}
