<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_name', 'product_image'];

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
