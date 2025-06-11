<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // public function product()
    // {
    //     return $this->belongsTo(Product::class, 'product_id','id');
    // }

    public function product(){
        return $this->belongsTo('App\Models\Product', 'product_id', 'id')->select('id', 'sku', 'requires_shipping', 'sell_when_out_of_stock', 'url_slug', 'weight_unit', 'weight', 'brand_id', 'has_variant', 'has_inventory', 'Requires_last_mile', 'averageRating', 'deleted_at')->whereNotNull('category_id')->withTrashed()->where('is_live', 1); 
      }

}
