<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measurements extends Model
{
    use HasFactory;
    protected $table="measurements";

    protected $fillable=['measurement_key_id','category_id','field_type','vendor_id'];
    public function category()
	{
		return $this->hasOne('App\Models\Category', 'id', 'category_id');
	}
    public function productVariants()
    {
        return $this->belongsToMany(
            ProductVariant::class,
            'product_measurement',
            'key_id',
            'product_variant_id'
        )->withPivot('product_id', 'key_value');
    }

    public function masterMeasurementKey(){
        return $this->hasOne('App\Models\MasterMeasurementKey','id','measurement_key_id');
    }
}