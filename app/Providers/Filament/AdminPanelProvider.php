<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('/admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                \App\Filament\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->renderHook(
                'panels::head.end',
                fn(): string => '<style>
                    /* Force 4 columns for stats overview widget */
                    .filament-widgets-stats-overview-widget {
                        display: grid !important;
                        grid-template-columns: repeat(4, 1fr) !important;
                        gap: 1.5rem !important;
                    }

                    /* Responsive adjustments */
                    @media (max-width: 1024px) {
                        .filament-widgets-stats-overview-widget {
                            grid-template-columns: repeat(2, 1fr) !important;
                        }
                    }

                    @media (max-width: 640px) {
                        .filament-widgets-stats-overview-widget {
                            grid-template-columns: 1fr !important;
                        }
                    }

                    /* Left Border for Sidebar */
                    .fi-sidebar {
                         box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1) !important;
                        border-radius: 0.75rem !important;
                        border: 1px solid rgb(229 231 235) !important;
                        background-color: rgb(255 255 255) !important;
                    }

                    /* Enhanced Shadow Styling for All Panels */
                    .fi-ta-ctn,
                    .fi-section,
                    .fi-widget,
                    .fi-card,
                    .fi-panel,
                    .filament-tables-table-container,
                    .filament-widget,
                    .filament-stats-overview-widget .filament-stats-overview-widget-stat,
                    .fi-stats-overview-widget .fi-stats-overview-widget-stat,
                    .fi-statsoverview-card,
                    /* .fi-section-content-ctn, */
                    .fi-section-header-ctn,
                    .fi-fieldset-ctn {
                        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1) !important;
                        border-radius: 0.75rem !important;
                        border: 1px solid rgb(229 231 235) !important;
                        background-color: rgb(255 255 255) !important;
                    }

                    /* Dark mode shadow styling */
                    .dark .fi-ta-ctn,
                    .dark .fi-section,
                    .dark .fi-widget,
                    .dark .fi-card,
                    .dark .fi-panel,
                    .dark .filament-tables-table-container,
                    .dark .filament-widget,
                    .dark .filament-stats-overview-widget .filament-stats-overview-widget-stat,
                    .dark .fi-stats-overview-widget .fi-stats-overview-widget-stat,
                    .dark .fi-statsoverview-card,
                    /* .dark .fi-section-content-ctn, */
                    .dark .fi-section-header-ctn,
                    .dark .fi-fieldset-ctn {
                        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.3), 0 1px 2px -1px rgb(0 0 0 / 0.3) !important;
                        border: 1px solid rgb(55 65 81) !important;
                        background-color: rgb(17 24 39) !important;
                    }

                    /* Enhanced widget shadows */
                    .fi-widget-heading,
                    .fi-widget-content,
                    .filament-widget .filament-widget-heading,
                    .filament-widget .filament-widget-content {
                        border-radius: 0.5rem !important;
                    }

                    /* Table specific shadow enhancements */
                    .fi-ta-table,
                    .filament-tables-table {
                        border-radius: 0.75rem !important;
                        overflow: hidden !important;
                    }

                    /* Form section shadows */
                    .fi-form-section,
                    .fi-form-section-content,
                    .filament-forms-section-component {
                        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1) !important;
                        border-radius: 0.75rem !important;
                        border: 1px solid rgb(229 231 235) !important;
                        background-color: rgb(255 255 255) !important;
                    }

                    .dark .fi-form-section,
                    .dark .fi-form-section-content,
                    .dark .filament-forms-section-component {
                        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.3), 0 1px 2px -1px rgb(0 0 0 / 0.3) !important;
                        border: 1px solid rgb(55 65 81) !important;
                        background-color: rgb(17 24 39) !important;
                    }

                    /* Target Filament table headers specifically */
                    .fi-ta-table th {
                        line-height: 1.2 !important;
                        vertical-align: top !important;
                        padding: 14px 10px !important;
                        height: auto !important;
                        min-height: 55px !important;
                        text-align: left !important;
                        position: relative !important;
                    }
                    
                    /* Target the header cell label */
                    .fi-ta-table th .fi-ta-header-cell-label {
                        line-height: 1.2 !important;
                        display: block !important;
                        text-align: left !important;
                        font-size: 0.8rem !important;
                        font-weight: 500 !important;
                        color: rgb(55 65 81) !important;
                        margin: 0 !important;
                        padding: 0 !important;
                        width: calc(100% - 25px) !important;
                    }
                    
                    /* Style the first line (English) */
                    .fi-ta-table th .fi-ta-header-cell-label::first-line {
                        font-weight: 600 !important;
                        color: rgb(17 24 39) !important;
                        font-size: 0.8rem !important;
                        display: block !important;
                        margin-bottom: 2px !important;
                        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
                        line-height: 1.2 !important;
                    }
                    
                    /* Style Arabic text with Arial font */
                    .fi-ta-table th .fi-ta-header-cell-label {
                        font-family: Arial, "Helvetica Neue", Helvetica, sans-serif !important;
                    }
                    
                    /* Position the sort button */
                    .fi-ta-table th .fi-ta-header-cell-sort-button {
                        position: absolute !important;
                        right: 8px !important;
                        top: 8px !important;
                        width: 18px !important;
                        height: 18px !important;
                        display: flex !important;
                        align-items: center !important;
                        justify-content: center !important;
                        margin: 0 !important;
                        padding: 0 !important;
                        background: none !important;
                        border: none !important;
                        cursor: pointer !important;
                    }
                    
                    /* Style the sort button icon */
                    .fi-ta-table th .fi-ta-header-cell-sort-button svg {
                        width: 14px !important;
                        height: 14px !important;
                        color: rgb(107 114 128) !important;
                    }
                    
                    /* Ensure proper text wrapping */
                    .fi-ta-table th {
                        word-wrap: break-word !important;
                        overflow-wrap: break-word !important;
                    }
                    
                    /* Better spacing for the header row */
                    .fi-ta-table thead tr {
                        height: auto !important;
                    }
                    
                    /* Ensure the header cell container has proper positioning */
                    .fi-ta-table th .fi-ta-header-cell {
                        position: relative !important;
                        padding: 0 !important;
                        height: auto !important;
                        min-height: 50px !important;
                    }
                    
                    /* Apply Arial font to all Arabic text in the application */
                    body, .fi-ta-table, .filament-tables, .fi-ta-table td, .fi-ta-table th {
                        font-family: Arial, "Helvetica Neue", Helvetica, sans-serif !important;
                    }
                    
                    /* Ensure form labels also use Arial for Arabic */
                    .fi-ta-fieldset-label, .fi-ta-fieldset-description, 
                    .fi-ta-input-label, .fi-ta-textarea-label,
                    .fi-ta-select-label, .fi-ta-date-picker-label {
                        font-family: Arial, "Helvetica Neue", Helvetica, sans-serif !important;
                    }
                    
                    /* Minimum width for table columns - this creates the min-width effect */
                    .fi-ta-table th[style*="width: 80px"] {
                        min-width: 80px !important;
                        width: auto !important;
                    }
                    .fi-ta-table th[style*="width: 100px"] {
                        min-width: 100px !important;
                        width: auto !important;
                    }
                    .fi-ta-table th[style*="width: 120px"] {
                        min-width: 120px !important;
                        width: auto !important;
                    }
                    .fi-ta-table th[style*="width: 130px"] {
                        min-width: 130px !important;
                        width: auto !important;
                    }
                    .fi-ta-table th[style*="width: 140px"] {
                        min-width: 140px !important;
                        width: auto !important;
                    }
                    .fi-ta-table th[style*="width: 150px"] {
                        min-width: 150px !important;
                        width: auto !important;
                    }
                    .fi-ta-table th[style*="width: 180px"] {
                        min-width: 180px !important;
                        width: auto !important;
                    }
                    .fi-ta-table th[style*="width: 200px"] {
                        min-width: 200px !important;
                        width: auto !important;
                    }
                </style>'
            );
    }
}
