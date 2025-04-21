<?php

// app/Models/CustomerEnquiry.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class CustomerEnquiry extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable;

    protected $fillable = [
        'user_name',
        'company_name',
        'phone',
        'email',
        'password',  
        'location',
        'product_id',
    ];

    protected $hidden = [
        'password', // Hide password when returning data
    ];

    // Define the relationship to CustomerQuotation (One-to-Many)
    public function customerQuotations()
    {
        return $this->hasMany(CustomerQuotation::class, 'user_id');  // Assuming 'user_id' is the foreign key in the customer_quotation table
    }
}

