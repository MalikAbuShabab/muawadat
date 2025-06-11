<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRefferal extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'refferal_code',
        'reffered_by',
        'user_id',
        'redeemed',
    ];

    protected $casts = [
        'redeemed' => 'boolean',
    ];

    public function referrer()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
