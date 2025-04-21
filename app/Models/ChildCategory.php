<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildCategory extends Model
{
    use HasFactory;

  protected $fillable = [
        'category_id',
        'subcategory_id',
        'name',
        'user_id',
        'default_image'
    ];

     // Explicitly define the table name
     protected $table = 'child_categories'; // Ensure this matches your table name

    
        public function category()
{
    return $this->belongsTo(Category::class, 'category_id');
}

public function subcategory()
{
    return $this->belongsTo(Subcategory::class, 'subcategory_id');
}

}
