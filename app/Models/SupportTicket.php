<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    public $table = "support_tickets";

    protected $fillable = ['user_id', 'subject', 'message', 'status', 'admin_response'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
