<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'issuer_id',
        'customer_name',
        'account_number',
        'city_id',
        'representative_name',
        'mobile_number',
        'address',
        'remarks',
        'old_balance',
    ];

    protected $casts = [
        'old_balance' => 'decimal:2',
    ];

    protected $appends = [
        'overall_payments',
        'overall_discount',
        'overall_returned_goods',
        'overall_invoices',
        'current_balance',
        'calculated_payment_percentage',
    ];

    public function issuer(): BelongsTo
    {
        return $this->belongsTo(Issuer::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    // Calculate overall payments (اجمالي المدفوع) - sum of debit transactions
    public function getOverallPaymentsAttribute()
    {
        return $this->transactions()
            ->where('type', 'debit')
            ->sum('total_amount') ?? 0;
    }

    // Calculate overall discount (الخصم) - sum of discount transactions
    public function getOverallDiscountAttribute()
    {
        return $this->transactions()
            ->where('type', 'discount')
            ->sum('total_amount') ?? 0;
    }

    // Calculate overall returned goods (المرتجع) - sum of return_goods transactions
    public function getOverallReturnedGoodsAttribute()
    {
        return $this->transactions()
            ->where('type', 'return_goods')
            ->sum('total_amount') ?? 0;
    }

    // Calculate overall invoices total from invoice items
    public function getOverallInvoicesAttribute()
    {
        return $this->invoices()
            ->with('items')
            ->get()
            ->sum(function ($invoice) {
                return $invoice->items ? $invoice->items->sum('total') : 0;
            }) ?? 0;
    }

    // Calculate current balance: (Debit + Discount + Returned Goods) - (Old Balance + New Invoices)
    public function getCurrentBalanceAttribute()
    {
        $debit = $this->overall_payments;
        $discount = $this->overall_discount;
        $returnedGoods = $this->overall_returned_goods;
        $oldBalance = $this->old_balance;
        $newInvoices = $this->overall_invoices;

        return ($debit + $discount + $returnedGoods) - ($oldBalance + $newInvoices);
    }

    // Calculate payment percentage: (Current Balance / Overall Invoices)
    public function getCalculatedPaymentPercentageAttribute()
    {
        $overallInvoices = $this->overall_invoices;

        if ($overallInvoices == 0) {
            return 0;
        }

        return ($this->current_balance / $overallInvoices) * 100;
    }
}
