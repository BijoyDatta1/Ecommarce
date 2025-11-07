<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubCategory extends Model
{
    use HasFactory;
    protected $table = 'sub_categoris';
    protected $fillable = ['name','slug','status','display','category_id'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    //create and update auto slag
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sub_categoris) {
            $sub_categoris->slug = Str::slug($sub_categoris->name);
        });

        static::updating(function ($sub_categoris) {
            $sub_categoris->slug = Str::slug($sub_categoris->name);
        });
    }
}
