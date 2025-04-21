<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Item extends Model


{

    protected $table = 'items';
    protected $fillable = [
        'id', 'product_id', 'name', 'brand', 'uom', 'sales_price', 
        'purchase_price', 'status', 'tax', 'vendor_id', 
        'expiration_date', 'product_image', 'specification_value', 'specification_name',
        'categoryid', 'subcategoryid', 'childcategoryid', 'Date',
        'gallery_images', 'gallery_video', 'hot_sale', 'top_sale', 
        'newyear_offer', 'fixing_of_margin', 'festival', 'vendor_status', 
        'description', 'user_id', 'add_highlight', 'product_status', 'member_id'
    ];
    

    // Relationship with VendorDetails
    public function vendorRegister()
{
    return $this->belongsTo(VendorRegister::class, 'vendor_id', 'id');
}


    // Relationship with Category
  // Relationship with Category
  public function category()
  {
      return $this->belongsTo(Category::class, 'categoryid', 'Category_id');
  }
  
  public function subcategory()
  {
      return $this->belongsTo(Subcategory::class, 'subcategoryid');
  }
  
  public function childcategory()
  {
      return $this->belongsTo(ChildCategory::class, 'childcategoryid');
  }
  

    // Relationship with Unit
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'uom', 'abbreviation');
    }

    protected static function boot()
{
    parent::boot();

    static::saving(function ($item) {
        Log::info('Saving item:', ['status' => $item->status, 'vendor_status' => $item->vendor_status]);
    });
}

}
