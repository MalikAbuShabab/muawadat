<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialInfo extends Model
{
    use HasFactory;
    
    public $table="financial_infos";

    protected $fillable = ['id', 'company_id', 'growth_opportunity', 'financial_data', 'matrics', 'data_room', 'marketing', 'price', 'offer_type', 'proposed_price', 'notes_offer', 'phone', 'email_address', 'share_precentage', 'start_date', 'sale_reason','nda'];
}
