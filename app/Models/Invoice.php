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
        'invoice_no',
        'customer_id',
        'total',
        'due',
        'status',
        'profit',
        'kra_cu_invoice_no',
        'kra_cu_serial_no',
        'kra_receipt_signature',
        'kra_internal_data',
        'kra_qr_url',
        'kra_signed_at',
    ];

    protected $casts = [
        'kra_signed_at' => 'datetime',
    ];

    /**
     * True once KRA eTIMS has signed this sale and returned its QR link.
     */
    public function isKraSigned(): bool
    {
        return filled($this->kra_cu_invoice_no) && filled($this->kra_qr_url);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
