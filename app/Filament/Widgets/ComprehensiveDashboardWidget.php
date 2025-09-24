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
use Illuminate\Support\HtmlString;

class ComprehensiveDashboardWidget extends BaseWidget
{
    protected int|string|array $columnSpan = 'full'; // spans full width

    protected function getColumns(): int
    {
        return 4; // ✅ Always 4 columns (desktop, tablet, mobile)
    }
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
        $activeCustomers = $filteredCustomers->where('current_balance', '<', 0)->count();

        // Calculate payment percentage
        $paymentPercentage = $totalDueAmounts > 0 ? (($totalPayments + $totalDiscounts + $totalReturnedGoods) / $totalDueAmounts) * 100 : 0;

        // Calculate overdue balances (customers with positive current balance)
        $overdueBalances = $filteredCustomers->where('current_balance', '>', 0)->sum('current_balance');

        return [
            // 1. Overall Balances (أجمالي الأرصدة)
            Stat::make('', number_format($remainingBalance, 2))
                ->description(new HtmlString("Overall Balances<br>أجمالي الأرصدة"))
                ->color(
                    $remainingBalance < 0
                    ? 'danger'
                    : ($remainingBalance > 0 ? 'warning' : 'success')
                )
                ->extraAttributes([
                    'class' => 'flex flex-col items-center text-center mb-3 [&_.fi-stats-overview-stat-value]:text-red-600 [&_.fi-stats-overview-stat-value]:font-bold [&_.fi-stats-overview-stat-value]:text-3xl',
                ]),

            // 2. Overall Debit (أجمالي التحصيل)
            Stat::make('', number_format($totalPayments, 2))
                ->description(new HtmlString("Overall Debit<br>أجمالي التحصيل"))
                ->color('success')
                ->extraAttributes(['class' => 'flex flex-col items-center text-center mb-3 [&_.fi-stats-overview-stat-value]:text-3xl [&_.fi-stats-overview-stat-value]:font-bold']),

            // 3. Overall Discount (أجمالي الخصم)
            Stat::make('', number_format($totalDiscounts, 2))
                ->description(new HtmlString("Overall Discount<br>أجمالي الخصم"))
                ->color('info')
                ->extraAttributes(['class' => 'flex flex-col items-center text-center mb-3 [&_.fi-stats-overview-stat-value]:text-3xl [&_.fi-stats-overview-stat-value]:font-bold']),

            // 4. Overall Return (أجمالي المرتجع)
            Stat::make('', number_format($totalReturnedGoods, 2))
                ->description(new HtmlString("Overall Return<br>أجمالي المرتجع"))
                ->color('gray')
                ->extraAttributes(['class' => 'flex flex-col items-center text-center mb-3 [&_.fi-stats-overview-stat-value]:text-3xl [&_.fi-stats-overview-stat-value]:font-bold']),

            // 5. % of Payments (نسبة المدفوع)
            Stat::make('', number_format($paymentPercentage, 2) . '%')
                ->description(new HtmlString("% of Payments<br>نسبة المدفوع"))
                ->color(
                    $paymentPercentage >= 80 ? 'success'
                    : ($paymentPercentage >= 50 ? 'warning' : 'danger')
                )
                ->extraAttributes([
                    'class' => 'flex flex-col items-center text-center mb-3 [&_.fi-stats-overview-stat-value]:text-red-600 [&_.fi-stats-overview-stat-value]:font-bold [&_.fi-stats-overview-stat-value]:text-3xl',
                ]),

            // 6. Due Balances (أجمالي الأرصدة المتاخرة)
            Stat::make('', number_format($overdueBalances, 2))
                ->description(new HtmlString("Due Balances<br>أجمالي الأرصدة المتاخرة"))
                ->color($overdueBalances > 0 ? 'danger' : 'success')
                ->extraAttributes(['class' => 'flex flex-col items-center text-center mb-3 [&_.fi-stats-overview-stat-value]:text-3xl [&_.fi-stats-overview-stat-value]:font-bold']),

            // 7. # of Active Customers (عدد العملاء النشيطين)
            Stat::make('', $activeCustomers)
                ->description(new HtmlString("# of Active Customers<br>عدد العملاء النشيطين"))
                ->color($activeCustomers > 0 ? 'warning' : 'success')
                ->extraAttributes(['class' => 'flex flex-col items-center text-center mb-3 [&_.fi-stats-overview-stat-value]:text-3xl [&_.fi-stats-overview-stat-value]:font-bold']),

            // 8. Overall Old Balance (أجمالي الأرصدة السابقة)
            Stat::make('', number_format($totalOldBalance, 2))
                ->description(new HtmlString("Overall Old Balance<br>أجمالي الأرصدة السابقة"))
                ->color('info')
                ->extraAttributes(['class' => 'flex flex-col items-center text-center mb-3 [&_.fi-stats-overview-stat-value]:text-3xl [&_.fi-stats-overview-stat-value]:font-bold']),
        ];

    }
}
