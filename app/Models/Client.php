<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'client_name', 'company_name', 'company_fullform', 'designation', 'client_image'];


    /**
     * The user that owns the client.
     */
    public function user()
    {
        return $this->belongsTo(Members::class);
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
