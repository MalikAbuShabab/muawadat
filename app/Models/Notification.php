<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';

    protected $fillable = [
        
        'id',
        'data',
        'read_at',
        'notifiable_id',
        'notifiable_type',
        'type',
    ];


}
