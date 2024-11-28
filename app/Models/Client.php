<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';
	protected $fillable = ['name', 'address', 'phone', 'email', 'notes', 'is_active', 'created_by', 'updated_by', 'created_at', 'updated_at'];

    public function getClientInfo()
    {
        $client = $this;
        return view("projects.client-info", compact("client"))->render();
    }


}
