<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingPage extends Model
{
    use HasFactory;

    protected $table = 'listingpages';  // Use your correct table name here
    protected $fillable = ['image','image_path'];  // The fields that are mass assignable
}
