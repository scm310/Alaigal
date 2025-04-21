<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'service_name', 'service_image'];

    /**
     * The user that owns the service.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function boot()
    {
        parent::boot();
    
        static::saved(function ($model) {
            $member = Members::find($model->user_id);
            if ($member) {
                $member->checkIfProfileCanBeUpdated();
            }
        });
    }
    
    

}
