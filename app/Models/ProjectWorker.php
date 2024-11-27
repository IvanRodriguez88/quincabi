<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectWorker extends Pivot
{
    protected $table = 'project_workers';

    protected $fillable = ['project_id', 'worker_id', 'hourly_pay', 'worked_hours']; 

    public $timestamps = true;
}
