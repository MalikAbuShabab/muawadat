<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P2pBid extends Model
{
    use HasFactory;

    protected $fillable = [ 'buyer_id', 'seller_id', 'product_id','bid_amount','bid_status','match_date', 'seller_reason', 'withdraw_reason', 'withdraw_by', 'confirm_term_condition', 'confirm_processed_payment', 'confirm_ownership_transfer'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id' ,'id')->select(['id', 'sku', 'description', 'vendor_id','title','url_slug']);
    }

    public function bidDocument()
    {
        return $this->hasOne(P2pBidDocument::class, 'bid_id', 'id');
    }

    public function bidMilestones()
    {
        return $this->hasMany(PaymentMilestone::class, 'bid_id', 'id');
    }


    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id', 'id')->select('id', 'name', 'email');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id', 'id')->select('id', 'name', 'email');
    }
    

}
