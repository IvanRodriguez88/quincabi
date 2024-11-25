<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;

    protected $table = 'workers';
	protected $fillable = ['name', 'hourly_pay', 'phone', 'email', 'notes', 'is_active', 'created_by', 'updated_by', 'created_at', 'updated_at'];

}
