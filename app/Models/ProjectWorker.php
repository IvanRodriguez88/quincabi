<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectWorker extends Pivot
{
    protected $table = 'project_workers';

    protected $fillable = ['project_id', 'worker_id', 'hourly_pay', 'worked_hours', 'date']; 

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    public function worker()
    {
        return $this->belongsTo(Worker::class, 'worker_id');
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
