<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawBidContract extends Model
{
    use HasFactory;
    public $table="withdraw_bid_contracts";
    protected $fillable = ['bid_id', 'withdraw_by', 'reason', 'otp', 'otp_verify', 'withdrawn_at'];
}
