<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class User extends Authenticatable
{
     use HasFactory, Notifiable;

    /** 
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'role_id', 'profile_pic'];
    protected $hidden = [
         'remember_token',
    ];
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function canAccess($permissionId)
    {
        // Check if the user's role has the given permission
        return $this->role->permissions()->where('permission_id', $permissionId)->exists();
    }
    public function hasPermission($permission)
    {
        return $this->role->permissions()->where('permission_id', $permission)->exists();
    }
}

