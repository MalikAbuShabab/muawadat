<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingDynamicField extends Model
{
    use HasFactory;

    public $table = "listing_dynamic_fields";

    protected $fillable = ['product_id', 'form_id', 'field_name', 'field_value'];
     
}
