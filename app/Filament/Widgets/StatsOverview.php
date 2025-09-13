<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Calculate remaining balance (sum of all current balances)
        $remainingBalance = Customer::all()->sum('current_balance');

        return [
            Stat::make('Total Issuers / إجمالي الموظفين', Customer::count())
                ->description('Registered Issuers / الموظفون المسجلون')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Stat::make('Total Invoices / إجمالي الفواتير', Invoice::count())
                ->description('All Invoices / جميع الفواتير')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('info'),

            Stat::make('Remaining Balance / المبالغ الغير مدفوعة', number_format($remainingBalance, 2))
                ->description('Total Outstanding Amount / إجمالي المبلغ المستحق')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color($remainingBalance < 0 ? 'danger' : 'success'),

            Stat::make('Total Transactions / إجمالي المعاملات', Transaction::count())
                ->description('All Transactions / جميع المعاملات')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('warning'),
        ];
    }
}
