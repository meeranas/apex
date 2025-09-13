<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'item_name',
        'item_number',
        'yards',
        'price_per_yard',
        'total',
    ];

    protected $casts = [
        'yards' => 'decimal:2',
        'price_per_yard' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
