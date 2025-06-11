<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P2pWithdrawOtp extends Model
{
    use HasFactory;
    protected $fillable = [
        'bid_id',
        'user_id',
        'email',
        'otp_code',
        'is_used',
        'expires_at',
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'expires_at' => 'datetime',
    ];
}
