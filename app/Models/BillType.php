<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillType extends Model
{
    use HasFactory;

    protected $table = 'bill_types';
	protected $fillable = ['name', 'is_active', 'created_by', 'updated_by'];
}
