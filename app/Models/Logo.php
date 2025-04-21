<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo_path','admin_name', 'admin_logo','heading','user_id',
    ];

   
}
