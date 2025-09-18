<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Filament\Widgets\CustomerReportsWidget;
use App\Filament\Widgets\CityReportsWidget;
use App\Filament\Widgets\IssuerReportsWidget;
use App\Filament\Widgets\DueDateAnalysisWidget;
use App\Services\ReportPdfService;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\Widget;
use Filament\Actions\Action;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Reports extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static string $view = 'filament.pages.reports';

    protected static ?string $title = 'Reports / التقارير';
    protected static ?string $navigationLabel = 'Reports / التقارير';

    protected static ?int $navigationSort = 3;

    public function getHeaderActions(): array
    {
        $user = Auth::user();
        $isAdmin = $user && $user->hasRole('admin');

        $actions = [
            Action::make('downloadCustomerReport')
                ->label('Download Customer Report / تحميل تقرير العملاء')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->action('downloadCustomerReport'),

            Action::make('downloadCityReport')
                ->label('Download City Report / تحميل تقرير المدن')
                ->icon('heroicon-o-document-arrow-down')
                ->color('info')
                ->action('downloadCityReport'),
        ];

        if ($isAdmin) {
            $actions[] = Action::make('downloadIssuerReport')
                ->label('Download Issuer Report / تحميل تقرير الموظفين')
                ->icon('heroicon-o-document-arrow-down')
                ->color('warning')
                ->action('downloadIssuerReport');

            $actions[] = Action::make('downloadDueDateAnalysis')
                ->label('Download Due Date Analysis / تحميل تحليل الاستحقاق')
                ->icon('heroicon-o-document-arrow-down')
                ->color('danger')
                ->action('downloadDueDateAnalysis');
        }

        return $actions;
    }

    public function downloadCustomerReport()
    {
        $pdfService = new ReportPdfService();
        return $pdfService->generateCustomerReportPdf();
    }

    public function downloadCityReport()
    {
        $pdfService = new ReportPdfService();
        return $pdfService->generateCityReportPdf();
    }

    public function downloadIssuerReport()
    {
        $pdfService = new ReportPdfService();
        return $pdfService->generateIssuerReportPdf();
    }

    public function downloadDueDateAnalysis()
    {
        $pdfService = new ReportPdfService();
        return $pdfService->generateDueDateAnalysisPdf();
    }

    public function getWidgets(): array
    {
        $user = Auth::user();
        $isAdmin = $user && $user->hasRole('admin');

        $widgets = [
            \App\Filament\Widgets\ReportsOverview::class,
        ];

        // Only show issuer-specific widgets for issuers
        if (!$isAdmin && $user && $user->hasRole('issuer') && $user->issuer) {
            $widgets[] = CustomerReportsWidget::class;
            $widgets[] = CityReportsWidget::class;
        } else if ($isAdmin) {
            // Admin sees all widgets
            $widgets[] = CustomerReportsWidget::class;
            $widgets[] = CityReportsWidget::class;
            $widgets[] = IssuerReportsWidget::class;
            $widgets[] = DueDateAnalysisWidget::class;
        }

        return $widgets;
    }

    /**
     * Get the columns for the widgets
     */
    public function getColumns(): int
    {
        return 2;
    }
}
