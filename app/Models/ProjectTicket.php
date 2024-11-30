<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectTicket extends Pivot
{
    protected $table = 'project_tickets';

    protected $fillable = ['project_id', 'path']; 

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
