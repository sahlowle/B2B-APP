<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentCard extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

     protected $fillable = [
        'user_id',
        'token',
        'status',
    ];

    public function scopeActive($query) {
        return $query->where('status', self::STATUS_ACTIVE);
    }
}
