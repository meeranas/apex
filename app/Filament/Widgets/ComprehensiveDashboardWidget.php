<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\Issuer;
use App\Models\City;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class ComprehensiveDashboardWidget extends BaseWidget
{
    protected $listeners = [
        'refreshWidget' => '$refresh',
        'updateFilters' => 'setFilters',
    ];

    public array $filters = [];

    public function setFilters(array $filters): void
    {
        $this->filters = $filters;
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
        if (!empty($filters['customer'])) {
            $customerQuery->where('id', $filters['customer']);
        }

        if (!empty($filters['city'])) {
            $customerQuery->where('city_id', $filters['city']);
        }

        if (!empty($filters['issuer'])) {
            $customerQuery->where('issuer_id', $filters['issuer']);
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

        // Calculate statistics
        $totalPayments = $filteredCustomers->sum('overall_payments');
        $totalDiscounts = $filteredCustomers->sum('overall_discount');
        $totalReturnedGoods = $filteredCustomers->sum('overall_returned_goods');
        $totalOldBalance = $filteredCustomers->sum('old_balance');
        $totalNewInvoices = $filteredCustomers->sum('overall_invoices');
        $totalDueAmounts = $totalNewInvoices + $totalOldBalance;
        
        $remainingBalance = $filteredCustomers->sum('current_balance');
        $customersWithRemainingBalance = $filteredCustomers->where('current_balance', '>', 0)->count();
        
        // Calculate payment percentage
        $paymentPercentage = $totalDueAmounts > 0 ? (($totalPayments + $totalDiscounts + $totalReturnedGoods) / $totalDueAmounts) * 100 : 0;

        return [
            Stat::make('Payment Percentage / نسبة الدفع', number_format($paymentPercentage, 2) . '%')
                ->description('Overall payment completion / إجمالي إتمام الدفع')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color($paymentPercentage >= 80 ? 'success' : ($paymentPercentage >= 50 ? 'warning' : 'danger')),

            Stat::make('Customers with Remaining Balance / العملاء ذوو الرصيد المتبقي', $customersWithRemainingBalance)
                ->description('Customers who owe money / العملاء المدينون')
                ->descriptionIcon('heroicon-m-users')
                ->color($customersWithRemainingBalance > 0 ? 'warning' : 'success'),

            Stat::make('Overall Old Balance / إجمالي الرصيد القديم', number_format($totalOldBalance, 2))
                ->description('Total old balance / إجمالي الرصيد القديم')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('info'),

            Stat::make('Overall New Balance / إجمالي الرصيد الجديد', number_format($totalNewInvoices, 2))
                ->description('Total from new invoices / إجمالي من الفواتير الجديدة')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),

            Stat::make('Overall Due Amounts / إجمالي المبالغ المستحقة', number_format($totalDueAmounts, 2))
                ->description('Total due amounts / إجمالي المبالغ المستحقة')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('warning'),

            Stat::make('Overall Discounts / إجمالي الخصومات', number_format($totalDiscounts, 2))
                ->description('Total discounts given / إجمالي الخصومات الممنوحة')
                ->descriptionIcon('heroicon-m-tag')
                ->color('success'),

            Stat::make('Overall Return Goods / إجمالي المرتجع', number_format($totalReturnedGoods, 2))
                ->description('Total returned goods / إجمالي البضائع المرتجعة')
                ->descriptionIcon('heroicon-m-arrow-uturn-left')
                ->color('gray'),
        ];
    }
}
