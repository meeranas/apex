<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use App\Models\Customer;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function beforeSave(): void
    {
        $data = $this->data;
        $currentRecord = $this->record;

        // Check for duplicate customer name (excluding current record)
        $existingCustomerByName = Customer::where('customer_name', $data['customer_name'])
            ->where('id', '!=', $currentRecord->id)
            ->first();
        if ($existingCustomerByName) {
            Notification::make()
                ->title('Duplicate Customer Name / اسم العميل مكرر')
                ->body('A customer with this name already exists. Please use a different customer name. / يوجد عميل بهذا الاسم مسبقاً. يرجى استخدام اسم مختلف.')
                ->danger()
                ->send();

            $this->halt();
        }

        // Check for duplicate account number (excluding current record)
        $existingCustomerByAccount = Customer::where('account_number', $data['account_number'])
            ->where('id', '!=', $currentRecord->id)
            ->first();
        if ($existingCustomerByAccount) {
            Notification::make()
                ->title('Duplicate Account Number / رقم الحساب مكرر')
                ->body('A customer with this account number already exists. Please use a different account number. / يوجد عميل برقم الحساب هذا مسبقاً. يرجى استخدام رقم حساب مختلف.')
                ->danger()
                ->send();

            $this->halt();
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
