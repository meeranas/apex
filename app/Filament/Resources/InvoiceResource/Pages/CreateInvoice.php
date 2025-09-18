<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateInvoice extends CreateRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // If user is an issuer, auto-set their issuer_id
        $user = Auth::user();
        if ($user && $user->hasRole('issuer') && $user->issuer) {
            $data['issuer_id'] = $user->issuer->id;
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getValidationRules(): array
    {
        return [
            'items' => ['required', 'array', 'min:1'],
        ];
    }

    protected function getValidationMessages(): array
    {
        return [
            'items.required' => 'At least one item is required / يجب إضافة منتج واحد على الأقل',
            'items.min' => 'At least one item is required / يجب إضافة منتج واحد على الأقل',
        ];
    }

    protected function beforeCreate(): void
    {
        // Additional validation to ensure at least one item exists
        $items = $this->data['items'] ?? [];
        if (empty($items) || count($items) < 1) {
            $this->halt('At least one item is required / يجب إضافة منتج واحد على الأقل');
        }
    }
}
