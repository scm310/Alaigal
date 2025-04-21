<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    use HasFactory;

    // Specify the table name explicitly if it does not follow the plural convention
    protected $table = 'footersetting';

    protected $fillable = [
        'title',
        'address1',
        'address2',
        'privacy_policy',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'color_code',
        'copyright_text',
        'design_by',
    
    ];
}
