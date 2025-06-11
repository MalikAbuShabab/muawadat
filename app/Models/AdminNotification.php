<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    use HasFactory;
    protected $table = 'admin_notifications';

    protected $fillable = [
        'notifiable_id',
        'notifiable_type',
        'type',
        'data',
        'read_at',
    ];
}
