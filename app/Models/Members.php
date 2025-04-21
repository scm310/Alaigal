<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;

// Import related models
use App\Models\Product;
use App\Models\Service;
use App\Models\Client;
use App\Models\Testimonial;
use App\Models\CompletedProject;
use App\Models\Subscription;


class Members extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'members'; // Explicitly define the table name

    protected $fillable = [
        'id','first_name', 'last_name', 'email', 'phone_number', 'company_name', 'location',
        'designation', 'password', 'date_of_birth', 'state', 'city',
        'pincode', 'industry', 'website', 'date_of_joining', 'profile_photo',
        'approve_status', 'payment', 'rejection_reason', 'profile_update','prime_member','pro','proj','ser','tem','det','cli','free_trial_start_date', 'free_trial_end_date',
    ];

    protected $hidden = [
        'password', 'remember_token', // Hide password fields
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'user_id', 'id');
    }


    public function services()
    {
        return $this->hasMany(Service::class, 'user_id', 'id');
    }

    public function clients()
    {
        return $this->hasMany(Client::class, 'user_id', 'id');
    }





    public function testimonials()
    {
        return $this->hasMany(Testimonial::class, 'user_id', 'id');
    }

    public function completedProjects()
    {
        return $this->hasMany(CompletedProject::class, 'user_id', 'id');
    }

  public function subscriptions()
{
    return $this->hasMany(Subscription::class, 'member_id', 'id');
}

public function latestSubscription()
{
    return $this->hasOne(Subscription::class, 'member_id', 'id')->latest();
}


public function hasActiveSubscription()
{
    return $this->latestSubscription && now()->lessThan($this->latestSubscription->end_date);
}


    public function checkIfProfileCanBeUpdated()
    {
        // Check if all required fields are set to 1
        $isProfileComplete = $this->pro == 1 &&
                             $this->proj == 1 &&
                             $this->ser == 1 &&
                             $this->tem == 1 &&
                             $this->det == 1 &&
                             $this->cli == 1;
    
        // Enable checkbox only if all conditions are met
        $this->profile_update = $isProfileComplete ? 1 : 0;
        
        $this->save();
    }
    


}
