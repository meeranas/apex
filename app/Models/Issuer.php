<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

class Issuer extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'full_name',
        'id_expiration',
        'photo',
        'password',
        'user_id',
    ];

    protected $casts = [
        'id_expiration' => 'date',
        'password' => 'hashed',
    ];

    protected $hidden = [
        'password',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    // Issuers that this issuer can view
    public function canViewIssuers(): BelongsToMany
    {
        return $this->belongsToMany(
            Issuer::class,
            'issuer_access',
            'issuer_id',
            'can_view_id'
        )->withTimestamps();
    }

    // Issuers that can view this issuer's data
    public function accessibleByIssuers(): BelongsToMany
    {
        return $this->belongsToMany(
            Issuer::class,
            'issuer_access',
            'can_view_id',
            'issuer_id'
        )->withTimestamps();
    }

    // Get all issuers that this issuer can view (including themselves)
    public function getAllViewableIssuers()
    {
        return Issuer::where('id', $this->id)
            ->orWhereIn('id', $this->canViewIssuers->pluck('id'))
            ->get();
    }

    // Get all customers that this issuer can view (their own + those from issuers they have access to)
    public function getAllViewableCustomers()
    {
        $viewableIssuerIds = $this->getAllViewableIssuers()->pluck('id');
        
        return Customer::whereIn('issuer_id', $viewableIssuerIds)->get();
    }
}
