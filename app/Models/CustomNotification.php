<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomNotification extends Model
{
    use HasFactory;

    protected $table = 'custom_notifications'; // Define the new table name

    protected $fillable = [
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at'
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    public function notifiable()
    {
        return $this->morphTo();
    }
}
