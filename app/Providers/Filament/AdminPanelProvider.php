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
