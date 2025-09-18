<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'document_number',
        'transaction_date',
        'customer_id',
        'amount',
        'payment_method',
        'total_amount',
        'remarks',
        'issuer_id',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    // Mutator to ensure amount is 0 for return_goods
    public function setAmountAttribute($value)
    {
        if ($this->type === 'return_goods') {
            $this->attributes['amount'] = 0;
        } else {
            $this->attributes['amount'] = $value;
        }
    }

    // Mutator to ensure amount is 0 when type is set to return_goods
    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = $value;
        if ($value === 'return_goods') {
            $this->attributes['amount'] = 0;
        }
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
        return $this->hasMany(TransactionItem::class);
    }
}
