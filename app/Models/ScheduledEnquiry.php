<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledEnquiry extends Model
{
    use HasFactory;

    // Define the table name if it's not the plural form of the model name
    protected $table = 'scheduled_enquiries';

    // Define which attributes are mass assignable
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'schedule_date',
         'user_id',
    ];

    // If you want to exclude timestamps, set the following
    public $timestamps = true;

    // Optionally, you can define the date format for the 'schedule_date' column
    protected $dates = [
        'schedule_date',
    ];
}

