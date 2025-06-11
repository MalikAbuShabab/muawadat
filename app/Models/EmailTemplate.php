<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    const STATUS_ACTIVE   = 1;
    const STATUS_INACTIVE = 0;

    use HasFactory;
    protected $fillable = ['slug', 'status'];

    protected static function boot() {
        parent::boot();
        self::addGlobalScope('active', fn ($q) => $q->where('status', self::STATUS_ACTIVE));
    }

    protected function scopeWithInactive($query) {
        return $query->withoutGlobalScope('active');
    }

    protected function scopeInactive($query) {
        return $query->withInactive()->where('status', self::STATUS_INACTIVE);
    }
}
