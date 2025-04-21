<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerQuotation extends Model
{
    use HasFactory;

    protected $table = 'customer_quotation';

    protected $fillable = [
        'user_id',
        'product_id',
        'product_name',
        'product_details',
        'price',
        'quantity',
        'sgst',
        'cgst',
        'subtotal'
    ];
}
