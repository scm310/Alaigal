<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyAsk extends Model
{
    use HasFactory;

    protected $table = 'my_ask'; // Ensure this matches your database

    protected $fillable = ['user_id', 'date', 'my_ask'];

    public function member()
    {
        return $this->belongsTo(Members::class, 'user_id');
    }


    protected $dates = ['date']; // Ensure the 'date' field is treated as a date

    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->attributes['date'])->format('d-m-Y h:i A');
    }
}

