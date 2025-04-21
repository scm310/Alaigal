<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Permission extends Model
{
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }
    
    use HasFactory;

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }
}
