<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class VendorRegister extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name', 'company_name', 'company_website',  
        'email', 'phone', 'gst_number', 'status', 'password','member_id','free_trial_start_date','free_trial_end_date',
    ];
    protected $hidden = ['password']; // Hide password from output

    protected $table = 'vendor_registers'; // Ensure correct table name

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($vendor) {
            if (empty($vendor->status)) {
                $vendor->status = 'pending';
            }
        });
    }






   
}
