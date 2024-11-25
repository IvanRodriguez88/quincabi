<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPaymentType extends Model
{
    use HasFactory;

    protected $table = 'project_payment_types';
	protected $fillable = ['name', 'description', 'is_active', 'created_by', 'updated_by'];
}
