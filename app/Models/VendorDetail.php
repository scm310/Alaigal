<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Import Authenticatable class
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract; // Import Authenticatable contract
use Illuminate\Support\Facades\Hash;

// VendorDetail.php
class VendorDetail extends Authenticatable implements AuthenticatableContract
{
    use HasFactory;

    // Define the table name (optional)
    protected $table = 'vendor_details';

    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'vendor_id', 'vendor_name', 'phone_number', 'email', 'gst_no', 
        'company_name', 'company_logo','website', 'profile_photo', 'vendor_category_id', 
        'address', 'city', 'state', 'zipcode', 'country', 'password','user_id'
    ];

    // Hide sensitive fields when serializing
    protected $hidden = [
        'password',
    ];

    // Relationships

    /**
     * One-to-One relationship with Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'vendor_category_id', 'Category_id');
    }

    /**
     * One-to-Many relationship with Item
     */
    public function items()
    {
        return $this->hasMany(Item::class, 'vendor_id', 'id');
    }

    // Automatically hash the password when it is set
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
    
    
        public function user()
{
    return $this->belongsTo(User::class);
}
}
