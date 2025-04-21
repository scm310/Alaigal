<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingBanner extends Model
{
    use HasFactory;

    protected $fillable = ['banner_image', 'category_id'];





    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'Category_id');
    }
    


}