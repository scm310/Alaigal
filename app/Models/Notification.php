<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // Define the table name if it's not the plural form of the model name
    protected $table = 'notifications';

    // Define the fillable attributes
    protected $fillable = [
        'product_id',
        'vendor_id',
        'category_id',
        'subcategory_id',
        'child_category_id',
        'status',
        'user_id',
    ];

  
}
