<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryItem extends Model
{
    use HasFactory;

	protected $table = 'category_items';
	protected $fillable = ['category_id', 'category_item_id', 'name', 'order', 'created_at', 'updated_at'];

	public function categoryItems()
	{
		return $this->hasMany('App\Models\CategoryItem');
	}

}
