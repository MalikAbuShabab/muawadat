<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMeasurement extends Model
{
    use HasFactory;
    protected $table="user_measurement";
    protected $fillable=['user_id','measurement_key_id','measurement_value'];

    public function measurementDetails(){
        return $this->hasOne('App\Models\MasterMeasurementKey','id','measurement_key_id');

    }
}