<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedProject extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'project_name', 'location', 'client_name', 'project_image','company_name'];

    /**
     * The user that owns the completed project.
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
