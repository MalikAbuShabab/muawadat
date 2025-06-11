<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMilestone extends Model
{
    use HasFactory;
    public $table = 'payments_milestones'; 

    protected $fillable = [ 'id','product_id', 'bid_id', 'total_milestone', 'created_by','milestone_type','amount','due_date','status', 'seller_reason','is_approved', 'is_paid', 'pay_date'];

}
