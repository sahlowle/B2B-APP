<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'invoice_file',
        'total_amount',
        'currency',
        'user_id',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


  
    /**
     * Generate unique invoice number
     */
    public static function generateInvoiceNumber(): string
    {
        $prefix = 'INV-';
        $lastInvoice = self::orderBy('id', 'desc')->first();
        $number = $lastInvoice ? $lastInvoice->id + 1 : 1;
        
        return $prefix . str_pad($number, 6, '0', STR_PAD_LEFT);
    }

   

    /**
     * Get status options
     */
    public static function getStatusOptions(): array
    {
        return [
            'draft' => 'Draft',
            'sent' => 'Sent',
            'paid' => 'Paid',
            'overdue' => 'Overdue',
            'cancelled' => 'Cancelled',
        ];
    }
}
