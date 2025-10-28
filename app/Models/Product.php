<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";
    protected $fillable = ['name','slug','description','price','compare_price','category_id','sub_category_id','brand_id','featured','display','status','sku','barcode','track_qty','qty'];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });

        static::updating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }

    public function images(){
        return $this->hasMany(Image::class);
    }

}
