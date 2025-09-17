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
        'goods_delivery_document_number',
        'invoice_date',
        'customer_id',
        'due_date',
        'remarks',
        'issuer_id',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {
            if (empty($invoice->invoice_number)) {
                do {
                    // Format: INV-YYYYMMDD-HHMMSS-XXX (where XXX is random 3 digits)
                    $timestamp = now()->format('Ymd-His');
                    $randomSuffix = str_pad(random_int(0, 999), 3, '0', STR_PAD_LEFT);
                    $invoiceNumber = 'INV-' . $timestamp . '-' . $randomSuffix;
                } while (Invoice::where('invoice_number', $invoiceNumber)->exists());

                $invoice->invoice_number = $invoiceNumber;
            }
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function issuer(): BelongsTo
    {
        return $this->belongsTo(Issuer::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
