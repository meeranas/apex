<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\City;
use App\Models\Issuer;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Mpdf\Mpdf; // Replace DomPDF with mPDF
use Carbon\Carbon;

class ReportPdfService
{
    public function generateComprehensiveReportPdf($filters = [])
    {
        $user = Auth::user();
        $isAdmin = $user && $user->hasRole('admin');

        // Base query with role-based filtering
        $customerQuery = Customer::with(['city', 'issuer', 'invoices.items', 'transactions']);

        // Apply role-based filtering
        if (!$isAdmin && $user && $user->hasRole('issuer') && $user->issuer) {
            $issuer = $user->issuer;
            $viewableIssuerIds = $issuer->getAllViewableIssuers()->pluck('id');
            $customerQuery->whereIn('issuer_id', $viewableIssuerIds);
        }

        // Apply filters
        if (!empty($filters['issuer_ids'])) {
            $customerQuery->whereIn('issuer_id', $filters['issuer_ids']);
        }

        if (!empty($filters['city_ids'])) {
            $customerQuery->whereIn('city_id', $filters['city_ids']);
        }

        if (!empty($filters['customer_ids'])) {
            $customerQuery->whereIn('id', $filters['customer_ids']);
        }

        if (!empty($filters['product_ids'])) {
            $customerQuery->whereHas('invoices.items', function ($query) use ($filters) {
                $query->whereIn('product_id', $filters['product_ids']);
            });
        }

        if (!empty($filters['due_date_from'])) {
            $customerQuery->whereHas('invoices', function ($query) use ($filters) {
                $query->where('due_date', '>=', $filters['due_date_from']);
            });
        }

        if (!empty($filters['due_date_to'])) {
            $customerQuery->whereHas('invoices', function ($query) use ($filters) {
                $query->where('due_date', '<=', $filters['due_date_to']);
            });
        }

        $customers = $customerQuery->get();

        // Calculate overall statistics
        $overallBalance = $customers->sum('current_balance');
        $totalInvoices = $customers->sum('overall_invoices');
        $remainingBalance = $overallBalance;
        $percentageRemaining = $totalInvoices > 0 ? ($remainingBalance / $totalInvoices) * 100 : 0;

        // Prepare customer data with proper encoding
        $customerData = $customers->map(function ($customer) {
            return [
                'name' => $this->ensureUtf8($customer->customer_name),
                'city' => $this->ensureUtf8($customer->city->name ?? 'N/A'),
                'old_balance' => (float) $customer->old_balance,
                'total_invoices' => (float) $customer->overall_invoices,
                'remaining_balance' => (float) $customer->current_balance,
            ];
        });

        // Get filter options for display
        $filterOptions = $this->getFilterOptions($filters);

        $data = [
            'customers' => $customerData,
            'statistics' => [
                'overall_balance' => (float) $overallBalance,
                'total_invoices' => (float) $totalInvoices,
                'remaining_balance' => (float) $remainingBalance,
                'percentage_remaining' => (float) $percentageRemaining,
            ],
            'filters' => $filterOptions,
            'generated_at' => now()->format('Y-m-d H:i:s'),
        ];

        // Configure mPDF with LTR support
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L', // Landscape
            'default_font' => 'dejavusans', // Supports Arabic and English
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
            'margin_header' => 10,
            'margin_footer' => 10,
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
        ]);

        // Set LTR direction for the entire document
        $mpdf->SetDirectionality('ltr');

        $mpdf->SetHTMLFooter('
            <div style="text-align: center; font-family: Inter, sans-serif; font-size: 10px; color: #6b7280; padding: 10px 0; border-top: 1px solid #e5e7eb;">
                Page {PAGENO} of {nbpg} | Generated on ' . now()->format('d-m-Y H:i:s') . ' | Apex
            </div>
        ');

        // Load the view and convert to HTML
        $html = view('filament.pdf.comprehensive-report', $data)->render();

        // Write HTML to PDF
        $mpdf->WriteHTML($html);

        // Return the PDF
        return $mpdf->Output('comprehensive-report-' . now()->format('Y-m-d-H-i-s') . '.pdf', 'D');
    }

    private function ensureUtf8($string)
    {
        if (is_null($string)) {
            return '';
        }

        // Convert to UTF-8 if not already
        if (!mb_check_encoding($string, 'UTF-8')) {
            $string = mb_convert_encoding($string, 'UTF-8', 'auto');
        }

        return $string;
    }

    private function getFilterOptions($filters)
    {
        $options = [];

        if (!empty($filters['issuer_ids'])) {
            $issuers = Issuer::whereIn('id', $filters['issuer_ids'])->pluck('full_name', 'id');
            $options['issuers'] = $issuers->map(function ($name) {
                return $this->ensureUtf8($name);
            });
        }

        if (!empty($filters['city_ids'])) {
            $cities = City::whereIn('id', $filters['city_ids'])->pluck('name', 'id');
            $options['cities'] = $cities->map(function ($name) {
                return $this->ensureUtf8($name);
            });
        }

        if (!empty($filters['customer_ids'])) {
            $customers = Customer::whereIn('id', $filters['customer_ids'])->pluck('customer_name', 'id');
            $options['customers'] = $customers->map(function ($name) {
                return $this->ensureUtf8($name);
            });
        }

        if (!empty($filters['product_ids'])) {
            $products = Product::whereIn('id', $filters['product_ids'])->pluck('name', 'id');
            $options['products'] = $products->map(function ($name) {
                return $this->ensureUtf8($name);
            });
        }

        if (!empty($filters['due_date_from'])) {
            $options['due_date_from'] = $filters['due_date_from'];
        }

        if (!empty($filters['due_date_to'])) {
            $options['due_date_to'] = $filters['due_date_to'];
        }

        return $options;
    }

    // Legacy methods for backward compatibility
    public function generateCustomerReportPdf()
    {
        return $this->generateComprehensiveReportPdf();
    }

    public function generateCityReportPdf()
    {
        return $this->generateComprehensiveReportPdf();
    }

    public function generateIssuerReportPdf()
    {
        return $this->generateComprehensiveReportPdf();
    }

    public function generateDueDateAnalysisPdf()
    {
        return $this->generateComprehensiveReportPdf();
    }
}
