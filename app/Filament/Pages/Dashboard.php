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
use Filament\Actions\Action;
use Filament\Forms\Components\Section;
use App\Filament\Widgets\FilteredStatsOverview;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseDashboard implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.pages.dashboard';

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

                        // Select::make('city')
                        //     ->label('City / المدينة')
                        //     ->options(function () use ($isAdmin, $user) {
                        //         if ($isAdmin) {
                        //             return Customer::distinct()->pluck('city', 'city')->toArray();
                        //         }

                        //         if ($user && $user->hasRole('issuer') && $user->issuer) {
                        //             $issuer = $user->issuer;
                        //             $viewableIssuerIds = $issuer->getAllViewableIssuers()->pluck('id');
                        //             return Customer::whereIn('issuer_id', $viewableIssuerIds)
                        //                 ->distinct()
                        //                 ->pluck('city', 'city')
                        //                 ->toArray();
                        //         }

                        //         return [];
                        //     })
                        //     ->placeholder('Select City / اختر المدينة')
                        //     ->searchable()
                        //     ->reactive()
                        //     ->afterStateUpdated(fn() => $this->updateStatsWidget()),

                        DatePicker::make('due_date_from')
                            ->label('Due Date From / تاريخ الاستحقاق من')
                            ->reactive()
                            ->afterStateUpdated(fn() => $this->updateStatsWidget()),

                        DatePicker::make('due_date_to')
                            ->label('Due Date To / تاريخ الاستحقاق إلى')
                            ->reactive()
                            ->afterStateUpdated(fn() => $this->updateStatsWidget()),
                    ])
                    ->columns(4)
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
            FilteredStatsOverview::class,
        ];
    }

    /**
     * Emit current filter state to the stats widget
     */
    protected function updateStatsWidget(): void
    {
        $this->dispatch(
            'updateFilters',
            filters: $this->form->getState()
        )->to(\App\Filament\Widgets\FilteredStatsOverview::class);
    }
}
