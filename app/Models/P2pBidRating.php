<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P2pBidRating extends Model
{
    use HasFactory;
    public $table = "p2p_bid_ratings";
    protected $fillable = [ 'bid_id', 'user_id', 'rated_user_id','rating','average_rating','feedback', 'suggestion', 'deleted_at', 'created_at', 'updated_at'];

}
