<?php

namespace App\Filament\Resources\IssuerResource\Pages;

use App\Filament\Resources\IssuerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListIssuers extends ListRecords
{
    protected static string $resource = IssuerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn () => Auth::user()?->hasRole('admin') ?? false),
        ];
    }

    public function mount(): void
    {
        abort_unless(Auth::user()?->hasRole('admin'), 403);
        
        parent::mount();
    }
}
