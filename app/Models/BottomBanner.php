<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BottomBanner extends Model
{
    use HasFactory;

    protected $table = 'bottom_banners';
    protected $fillable = ['image'];
}

