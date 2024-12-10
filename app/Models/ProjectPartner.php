<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectPartner extends Pivot
{
    protected $table = 'project_partners';

    protected $fillable = ['project_id', 'partner_id', 'percentage', 'amount']; 

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
