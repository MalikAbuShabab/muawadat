<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterMeasurementKey extends Model
{
    use HasFactory;
    protected $table="master_measurements_keys";
    protected $fillable=['key_name'];
}