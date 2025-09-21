<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Issuer;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class IssuerStatsTableWidget extends Widget
{
    protected $listeners = [
        'refreshWidget' => '$refresh',
    ];

    protected static string $view = 'filament.widgets.issuer-stats-table-widget';

    protected int | string | array $columnSpan = 'full';

    public function getIssuerStats()
    {
        $user = Auth::user();
        $isAdmin = $user && $user->hasRole('admin');

        // Base query for issuers - NO FILTERS APPLIED
        $issuerQuery = Issuer::query();

        // Apply only role-based filtering (no other filters)
        if (!$isAdmin && $user && $user->hasRole('issuer') && $user->issuer) {
            $issuer = $user->issuer;
            $viewableIssuerIds = $issuer->getAllViewableIssuers()->pluck('id');
            $issuerQuery->whereIn('id', $viewableIssuerIds);
        }

        $issuers = $issuerQuery->get();

        // Calculate issuer statistics - NO FILTERS APPLIED
        $issuerStats = $issuers->map(function ($issuer) {
            // Get ALL customers for this issuer (no filters)
            $customers = Customer::where('issuer_id', $issuer->id)->get();

            $totalPayments = $customers->sum('overall_payments');
            $totalDiscounts = $customers->sum('overall_discount');
            $totalReturnedGoods = $customers->sum('overall_returned_goods');
            $totalOldBalance = $customers->sum('old_balance');
            $totalNewInvoices = $customers->sum('overall_invoices');
            $totalDueAmounts = $totalNewInvoices + $totalOldBalance;
            
            $remainingBalance = $customers->sum('current_balance');
            $paymentPercentage = $totalDueAmounts > 0 ? (($totalPayments + $totalDiscounts + $totalReturnedGoods) / $totalDueAmounts) * 100 : 0;

            return [
                'issuer_name' => $issuer->full_name,
                'remaining_balance' => $remainingBalance,
                'payment_percentage' => $paymentPercentage,
            ];
        });

        // Add totals row
        $totalRemainingBalance = $issuerStats->sum('remaining_balance');
        $totalPaymentPercentage = $issuerStats->avg('payment_percentage');

        $issuerStats->push([
            'issuer_name' => 'TOTAL / المجموع',
            'remaining_balance' => $totalRemainingBalance,
            'payment_percentage' => $totalPaymentPercentage,
        ]);

        return $issuerStats;
    }
}
