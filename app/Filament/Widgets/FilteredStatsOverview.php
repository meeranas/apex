<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\Issuer;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class FilteredStatsOverview extends BaseWidget
{
    protected $listeners = [
        'refreshWidget' => '$refresh',
        'updateFilters' => 'setFilters',
    ];

    public array $filters = [];

    public function setFilters(array $filters): void
    {
        $this->filters = $filters;

        // Refresh stats immediately when filters are updated
        $this->dispatch('$refresh');
    }

    protected function getStats(): array
    {
        $user = Auth::user();
        $isAdmin = $user && $user->hasRole('admin');
        
        $filters = $this->filters ?? [];

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

        // Apply additional filters
        if (!empty($filters['city'])) {
            $customerQuery->where('city', $filters['city']);
        }

        if (!empty($filters['issuer'])) {
            $invoiceQuery->where('issuer_id', $filters['issuer']);
            $transactionQuery->where('issuer_id', $filters['issuer']);
        }

        if (!empty($filters['due_date_from'])) {
            $invoiceQuery->where('due_date', '>=', $filters['due_date_from']);
        }

        if (!empty($filters['due_date_to'])) {
            $invoiceQuery->where('due_date', '<=', $filters['due_date_to']);
        }

        // If invoice filters are applied, filter customers by those invoices
        if (!empty($filters['issuer']) || !empty($filters['due_date_from']) || !empty($filters['due_date_to'])) {
            $customerIds = $invoiceQuery->pluck('customer_id')->unique();
            $customerQuery->whereIn('id', $customerIds);
        }

        $filteredCustomers = $customerQuery->get();

        $remainingBalance = $filteredCustomers->sum(function ($customer) {
            $debit = $customer->overall_payments;
            $discount = $customer->overall_discount;
            $returnedGoods = $customer->overall_returned_goods;
            $oldBalance = $customer->old_balance;
            $newInvoices = $customer->overall_invoices;

            return ($debit + $discount + $returnedGoods) - ($oldBalance + $newInvoices);
        });

        // Apply customer filtering to transactions
        if (!empty($filters)) {
            $customerIds = $customerQuery->pluck('id');
            $transactionQuery->whereIn('customer_id', $customerIds);
        }

        // Get issuer count based on role
        $issuerCount = $isAdmin ? Issuer::count() : 1; // Issuers only see themselves

        return [
            Stat::make('Total Issuers / إجمالي الموظفين', $issuerCount)
                ->description($isAdmin ? 'All Issuers / جميع الموظفين' : 'Your Account / حسابك')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Stat::make('Total Invoices / إجمالي الفواتير', $invoiceQuery->count())
                ->description($isAdmin ? 'All Invoices / جميع الفواتير' : 'Your Invoices / فواتيرك')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('info'),

            Stat::make('Remaining Balance / المبالغ الغير مدفوعة', number_format($remainingBalance, 2))
                ->description('Total Outstanding Amount / إجمالي المبلغ المستحق')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color($remainingBalance < 0 ? 'danger' : 'success'),

            Stat::make('Total Transactions / إجمالي المعاملات', $transactionQuery->count())
                ->description($isAdmin ? 'All Transactions / جميع المعاملات' : 'Your Transactions / معاملاتك')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('warning'),
        ];
    }
}
