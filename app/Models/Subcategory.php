<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name','user_id','default_image'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Subcategory Model
public function childcategories()
{
    return $this->hasMany(ChildCategory::class, 'subcategory_id', 'id');
}
}
