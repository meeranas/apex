<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\Issuer;
use App\Models\City;
use Filament\Actions\Action;
use Filament\Forms\Components\Section;
use App\Filament\Widgets\ComprehensiveDashboardWidget;
use App\Filament\Widgets\IssuerStatsTableWidget;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseDashboard implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.pages.dashboard';

    protected static ?string $navigationLabel = 'Dashboard / لوحة التحكم';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        $user = Auth::user();
        $isAdmin = $user && $user->hasRole('admin');

        return $form
            ->schema([
                Section::make('Dashboard Filters / مرشحات لوحة التحكم')
                    ->schema([
                        Select::make('issuer')
                            ->label('Issuer / الموظف')
                            ->options(function () use ($isAdmin, $user) {
                                if ($isAdmin) {
                                    return Issuer::pluck('full_name', 'id')->toArray();
                                }

                                if ($user && $user->hasRole('issuer') && $user->issuer) {
                                    return [$user->issuer->id => $user->issuer->full_name];
                                }

                                return [];
                            })
                            ->placeholder('Select Issuer / اختر الموظف')
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(fn() => $this->updateStatsWidget())
                            ->visible($isAdmin),

                        Select::make('customer')
                            ->label('Customer / العميل')
                            ->options(function () use ($isAdmin, $user) {
                                if ($isAdmin) {
                                    return Customer::with('issuer')->get()->mapWithKeys(function ($customer) {
                                        return [$customer->id => $customer->customer_name . ' (' . $customer->issuer->full_name . ')'];
                                    })->toArray();
                                }

                                if ($user && $user->hasRole('issuer') && $user->issuer) {
                                    $issuer = $user->issuer;
                                    $viewableIssuerIds = $issuer->getAllViewableIssuers()->pluck('id');
                                    return Customer::whereIn('issuer_id', $viewableIssuerIds)
                                        ->with('issuer')
                                        ->get()
                                        ->mapWithKeys(function ($customer) {
                                            return [$customer->id => $customer->customer_name . ' (' . $customer->issuer->full_name . ')'];
                                        })->toArray();
                                }

                                return [];
                            })
                            ->placeholder('Select Customer / اختر العميل')
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(fn() => $this->updateStatsWidget()),

                        Select::make('city')
                            ->label('City / المدينة')
                            ->options(function () use ($isAdmin, $user) {
                                if ($isAdmin) {
                                    return City::pluck('name', 'id')->toArray();
                                }

                                if ($user && $user->hasRole('issuer') && $user->issuer) {
                                    $issuer = $user->issuer;
                                    $viewableIssuerIds = $issuer->getAllViewableIssuers()->pluck('id');
                                    return Customer::whereIn('issuer_id', $viewableIssuerIds)
                                        ->with('city')
                                        ->get()
                                        ->pluck('city.name', 'city.id')
                                        ->filter()
                                        ->unique()
                                        ->toArray();
                                }

                                return [];
                            })
                            ->placeholder('Select City / اختر المدينة')
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(fn() => $this->updateStatsWidget()),

                        DatePicker::make('due_date_from')
                            ->label('Due Date From / تاريخ الاستحقاق من')
                            ->reactive()
                            ->afterStateUpdated(fn() => $this->updateStatsWidget()),

                        DatePicker::make('due_date_to')
                            ->label('Due Date To / تاريخ الاستحقاق إلى')
                            ->reactive()
                            ->afterStateUpdated(fn() => $this->updateStatsWidget()),
                    ])
                    ->columns(5)
                    ->collapsible()
                    ->collapsed(false)
                    ->persistCollapsed()
                    ->extraAttributes(['class' => 'mb-6']),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('clear_filters')
                ->label('Clear Filters / مسح المرشحات')
                ->color('gray')
                ->action(function () {
                    $this->form->fill();
                    $this->updateStatsWidget();
                }),
        ];
    }

    public function getWidgets(): array
    {
        return [
            ComprehensiveDashboardWidget::class,
            IssuerStatsTableWidget::class,
        ];
    }

    public function getColumns(): int|string|array
    {
        return [
            'xl' => 4, // 4 columns on extra large screens
            'lg' => 4, // 4 columns on large screens
            'md' => 4, // 4 columns on medium screens
            'sm' => 2, // 2 columns on small screens
            'default' => 1, // 1 column on mobile
        ];
    }

    /**
     * Emit current filter state to the stats widget only
     * IssuerStatsTableWidget is not affected by filters
     */
    protected function updateStatsWidget(): void
    {
        $this->dispatch(
            'updateFilters',
            filters: $this->form->getState()
        )->to(\App\Filament\Widgets\ComprehensiveDashboardWidget::class);
    }
}
