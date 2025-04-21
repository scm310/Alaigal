<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerBanner extends Model
{
    use HasFactory;

    protected $table = 'customer_banners';

    protected $fillable = [
        'image',
    ];
}


