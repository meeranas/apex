<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\Issuer;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class ReportsOverview extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $user = Auth::user();
        $isAdmin = $user && $user->hasRole('admin');
        
        // Base queries with role-based filtering
        $customerQuery = Customer::query();
        $invoiceQuery = Invoice::query();
        $transactionQuery = Transaction::query();

        // Apply role-based filtering
        if (!$isAdmin && $user && $user->hasRole('issuer') && $user->issuer) {
            $issuer = $user->issuer;
            $viewableIssuerIds = $issuer->getAllViewableIssuers()->pluck('id');
            
            $customerQuery->whereIn('issuer_id', $viewableIssuerIds);
            $invoiceQuery->whereIn('issuer_id', $viewableIssuerIds);
            $transactionQuery->whereIn('issuer_id', $viewableIssuerIds);
        }

        $customers = $customerQuery->get();
        $overallBalance = $customers->sum(function ($customer) {
            return $customer->current_balance;
        });

        return [
            Stat::make('Total Customers / إجمالي العملاء', $customerQuery->count())
                ->description($isAdmin ? 'All customers / جميع العملاء' : 'Your customers / عملاؤك')
                ->color('success'),

            Stat::make('Total Invoices / إجمالي الفواتير', $invoiceQuery->count())
                ->description($isAdmin ? 'All invoices / جميع الفواتير' : 'Your invoices / فواتيرك')
                ->color('info'),

            Stat::make('Total Transactions / إجمالي العمليات', $transactionQuery->count())
                ->description($isAdmin ? 'All transactions / جميع العمليات' : 'Your transactions / عملياتك')
                ->color('warning'),

            Stat::make(
                'Overall Balance / الرصيد الإجمالي',
                'SAR ' . number_format($overallBalance, 2)
            )
                ->description($isAdmin ? 'Total outstanding balance / إجمالي الرصيد المستحق' : 'Your outstanding balance / رصيدك المستحق')
                ->color('danger'),
        ];
    }
}
