<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Members;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'subscriptions';

    protected $fillable = [
        'member_id', 'plan_type', 'duration', 'product_count',
        'amount', 'payment_status', 'start_date', 'end_date', 'order_id'
    ];

    public function member()
    {
        return $this->belongsTo(Members::class, 'member_id', 'id');
    }
}

