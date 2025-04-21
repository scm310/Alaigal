<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryBanner extends Model
{
    use HasFactory;

    protected $table = 'category_banner'; // Table name

    protected $fillable = [
        'category_id',
        'banner',
    ];

    public $timestamps = true; // Enables created_at & updated_at

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'Category_id'); // Relationship with Category
    }
}
