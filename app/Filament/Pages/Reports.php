<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\ComprehensiveReportWidget;
use Illuminate\Support\Facades\Auth;

class Reports extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static string $view = 'filament.pages.reports';

    protected static ?string $title = 'Reports / التقارير';
    protected static ?string $navigationLabel = 'Reports / التقارير';

    protected static ?int $navigationSort = 3;

    public function getWidgets(): array
    {
        return [
            ComprehensiveReportWidget::class,
        ];
    }

    /**
     * Get the columns for the widgets
     */
    public function getColumns(): int
    {
        return 1;
    }
}
