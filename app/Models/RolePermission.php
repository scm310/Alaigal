<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;

    protected $table = 'role_permission';

    protected $fillable = [
        'role_id',
        'permission_id',
    ];

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }


      
}
