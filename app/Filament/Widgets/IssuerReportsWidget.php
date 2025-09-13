<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Issuer;
use Filament\Widgets\Widget;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class IssuerReportsWidget extends Widget
{
    protected static string $view = 'filament.widgets.issuer-reports-widget';

    protected int|string|array $columnSpan = 'md:col-span-1';

    public function getHeading(): string
    {
        return 'Reports by Issuer / تقارير حسب المُصدر';
    }

    public function getDescription(): string
    {
        return 'Customer and balance distribution by issuer / توزيع العملاء والرصيد حسب المُصدر';
    }

    /**
     * Get customer reports grouped by issuer
     */
    public function getCustomerReportsByIssuer()
    {
        return $this->getCustomerReports()->groupBy('issuer');
    }

    /**
     * Calculate overall current balance for all customers
     */
    public function getOverallCurrentBalance()
    {
        return Customer::all()->sum(function ($customer) {
            return $customer->current_balance;
        });
    }

    /**
     * Get detailed customer reports with all required information
     */
    public function getCustomerReports()
    {
        return Customer::with([
            'invoices' => function ($query) {
                $query->orderBy('due_date', 'asc');
            },
            'issuer'
        ])
            ->get()
            ->map(function ($customer) {
                $latestInvoice = $customer->invoices->first();

                return [
                    'customer_name' => $customer->customer_name,
                    'city' => $customer->city,
                    'issuer' => $customer->issuer ? $customer->issuer->full_name : 'N/A',
                    'current_balance' => $customer->current_balance,
                    'payment_percentage' => $customer->calculated_payment_percentage,
                    'due_date' => $latestInvoice ? $latestInvoice->due_date : null,
                    'due_date_status' => $this->getDueDateStatus($latestInvoice ? $latestInvoice->due_date : null),
                ];
            });
    }

    /**
     * Get due date status based on current date
     */
    private function getDueDateStatus($dueDate)
    {
        if (!$dueDate) {
            return 'no_invoice';
        }

        $now = Carbon::now();
        $due = Carbon::parse($dueDate);

        if ($due->isPast()) {
            return 'overdue';
        } elseif ($due->diffInDays($now) <= 7) {
            return 'due_soon';
        } else {
            return 'current';
        }
    }

    /**
     * Get status color for due date
     */
    public function getDueDateStatusColor($status)
    {
        return match ($status) {
            'overdue' => 'danger',
            'due_soon' => 'warning',
            'current' => 'success',
            'no_invoice' => 'gray',
            default => 'gray',
        };
    }

    /**
     * Get status text for due date
     */
    public function getDueDateStatusText($status)
    {
        return match ($status) {
            'overdue' => 'Overdue / متأخر',
            'due_soon' => 'Due Soon / قريب الاستحقاق',
            'current' => 'Current / جاري',
            'no_invoice' => 'No Invoice / لا توجد فاتورة',
            default => 'Unknown / غير معروف',
        };
    }

    /**
     * Get payment percentage color
     */
    public function getPaymentPercentageColor($percentage)
    {
        if ($percentage >= 80) {
            return 'success';
        } elseif ($percentage >= 50) {
            return 'warning';
        } else {
            return 'danger';
        }
    }

    /**
     * Get balance color
     */
    public function getBalanceColor($balance)
    {
        if ($balance < 0) {
            return 'success'; // Customer has credit
        } elseif ($balance > 1000) {
            return 'danger'; // High outstanding balance
        } else {
            return 'warning'; // Moderate balance
        }
    }
}
