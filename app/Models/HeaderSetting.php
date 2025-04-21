<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderSetting extends Model
{
    use HasFactory;

    protected $table = 'header_setting'; // Ensure the table name matches

    protected $fillable = ['logo', 'title'];
}
