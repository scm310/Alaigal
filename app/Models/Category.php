<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category'; // Explicit table name
    protected $primaryKey = 'Category_id'; // Define the primary key column
    public $incrementing = true; // Primary key is auto-incrementing
    protected $keyType = 'int'; // Primary key is an integer

  
    protected $fillable = [
        'Category_name',   // Category name
        'Category_image',  // Category image
        'status',          // Status field for visibility
        'user_id',         // Add user_id to store the authenticated user's ID
    ];

    // Relationship with subcategories
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class, 'category_id');
    }

    // Relationship with childcategories
    public function childcategories()
    {
        return $this->hasMany(ChildCategory::class);
  
    }
    

}
