<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSupport extends Model
{
    use HasFactory;

    protected $table = 'customer_support';

    protected $fillable = [
        'name',
        'email',
        'message',
        'status',
        'vendor_id'
    ];

    // Default attributes
    protected $attributes = [
        'status' => 'pending', // Default status
    ];
}
