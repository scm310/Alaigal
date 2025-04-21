<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginBanner extends Model
{
    use HasFactory;

    protected $table = 'loginbanner'; // Specify the table name

    protected $primaryKey = 'banner_id'; // Specify the primary key

    public $timestamps = true; // Enable timestamps

    protected $fillable = [
        'banner_image',
    ];
}

