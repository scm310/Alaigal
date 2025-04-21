<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BottomBanner1 extends Model {
    use HasFactory;

    protected $table = 'bottom_banner1'; // Specify table name

    protected $fillable = ['image'];
}

