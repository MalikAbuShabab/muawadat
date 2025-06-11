<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P2pBidDocument extends Model
{
    use HasFactory;
    public $table="p2pBidDocuments";
    protected $fillable = ['bid_id', 'document_name','document_path','buyer_signature','upload_buyer_id','doc_type','file_type','uploaded_by','created_at','updated_at','deleted_at'];

    public function bidData(){
        return $this->hasOne('App\Models\P2pBid', 'id', 'bid_id');
        // return $this->belongsTo('App\Models\P2pBidDocument', 'id' ,'bid_id')->select(['bid_id', 'document_name','document_path','file_type','uploaded_by','created_at','updated_at']);
    }

}
