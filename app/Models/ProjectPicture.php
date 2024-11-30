<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectPicture extends Pivot
{
    protected $table = 'project_pictures';

    protected $fillable = ['project_id', 'path']; 

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    public function filename()
    {
        $basename = basename($this->path); // Nombre completo del archivo (con extensión)
        return $basename; // Solo el nombre base sin extensión
    }
}
