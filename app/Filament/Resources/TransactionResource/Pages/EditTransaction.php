<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use App\Models\TransactionItem;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransaction extends EditRecord
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Get the original transaction data
        $originalData = $this->record->toArray();
        $originalType = $originalData['type'];
        $newType = $data['type'];

        // If changing from return_goods to any other type, delete all transaction items
        if ($originalType === 'return_goods' && $newType !== 'return_goods') {
            // Delete all transaction items for this transaction using the relationship
            $this->record->items()->delete();

            // Clear the items from form data
            $data['items'] = [];
        }

        return $data;
    }

    protected function afterSave(): void
    {
        // Double-check and clean up any remaining items if type is not return_goods
        if ($this->record->type !== 'return_goods') {
            $this->record->items()->delete();
        }
    }
}
