<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\City;
use App\Models\Issuer;
use App\Models\Product;
use Filament\Widgets\Widget;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class ComprehensiveReportWidget extends Widget implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.widgets.comprehensive-report-widget';
    protected int|string|array $columnSpan = 'full';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        $user = Auth::user();
        $isAdmin = $user && $user->hasRole('admin');

        // Base queries with role-based filtering
        $issuerQuery = Issuer::query();
        $customerQuery = Customer::query();

        // Apply role-based filtering
        if (!$isAdmin && $user && $user->hasRole('issuer') && $user->issuer) {
            $issuer = $user->issuer;
            $viewableIssuerIds = $issuer->getAllViewableIssuers()->pluck('id');
            $issuerQuery->whereIn('id', $viewableIssuerIds);
            $customerQuery->whereIn('issuer_id', $viewableIssuerIds);
        }

        return $form
            ->schema([
                Section::make('Report Filters / فلاتر التقرير')
                    ->description('Select filters to customize your report / اختر الفلاتر لتخصيص تقريرك')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('issuer_ids')
                                    ->label('Issuers / الموظفين')
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->options($issuerQuery->pluck('full_name', 'id'))
                                    ->placeholder('Select issuers / اختر الموظفين'),

                                Select::make('city_ids')
                                    ->label('Cities / المدن')
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->options(City::pluck('name', 'id'))
                                    ->placeholder('Select cities / اختر المدن'),

                                Select::make('customer_ids')
                                    ->label('Customers / العملاء')
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->options($customerQuery->pluck('customer_name', 'id'))
                                    ->placeholder('Select customers / اختر العملاء'),
                            ]),

                        Grid::make(3)
                            ->schema([
                                Select::make('product_ids')
                                    ->label('Products / المنتجات')
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->options(Product::pluck('name', 'id'))
                                    ->placeholder('Select products / اختر المنتجات'),

                                DatePicker::make('due_date_from')
                                    ->label('Due Date From / تاريخ الاستحقاق من')
                                    ->placeholder('Select start date / اختر تاريخ البداية'),

                                DatePicker::make('due_date_to')
                                    ->label('Due Date To / تاريخ الاستحقاق إلى')
                                    ->placeholder('Select end date / اختر تاريخ النهاية'),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(false),
            ])
            ->statePath('data');
    }

    public function generateReport()
    {
        try {
            $data = $this->form->getState();
            
            // Clean up empty values
            $filters = array_filter($data, function($value) {
                return !empty($value);
            });

            // Build query string for the filters
            $queryParams = [];
            foreach ($filters as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $item) {
                        $queryParams[] = $key . '[]=' . urlencode($item);
                    }
                } else {
                    $queryParams[] = $key . '=' . urlencode($value);
                }
            }

            $queryString = implode('&', $queryParams);
            $url = route('reports.download-comprehensive') . '?' . $queryString;

            // Log the URL for debugging
            \Log::info('Generated report URL: ' . $url);

            // Store the URL in a data attribute for JavaScript to access
            $this->js("
                const url = '{$url}';
                const link = document.createElement('a');
                link.href = url;
                link.target = '_blank';
                link.style.display = 'none';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            ");

            Notification::make()
                ->title('Report Generation Started')
                ->body('Your report is being generated and will download shortly.')
                ->success()
                ->send();
                
        } catch (\Exception $e) {
            \Log::error('Report generation error: ' . $e->getMessage());
            
            Notification::make()
                ->title('Error generating report')
                ->body('An error occurred while generating the report: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function clearFilters()
    {
        $this->form->fill();
        
        Notification::make()
            ->title('Filters Cleared')
            ->body('All filters have been cleared.')
            ->success()
            ->send();
    }
}
