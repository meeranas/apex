<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use App\Models\Customer;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // If user is an issuer, auto-set their issuer_id
        $user = Auth::user();
        if ($user && $user->hasRole('issuer') && $user->issuer) {
            $data['issuer_id'] = $user->issuer->id;
        }

        return $data;
    }

    protected function beforeCreate(): void
    {
        $data = $this->data;

        // Check for duplicate customer name
        $existingCustomerByName = Customer::where('customer_name', $data['customer_name'])->first();
        if ($existingCustomerByName) {
            Notification::make()
                ->title('Duplicate Customer Name / اسم العميل مكرر')
                ->body('A customer with this name already exists. Please use a different customer name. / يوجد عميل بهذا الاسم مسبقاً. يرجى استخدام اسم مختلف.')
                ->danger()
                ->send();

            $this->halt();
        }

        // Check for duplicate account number
        $existingCustomerByAccount = Customer::where('account_number', $data['account_number'])->first();
        if ($existingCustomerByAccount) {
            Notification::make()
                ->title('Duplicate Account Number / رقم الحساب مكرر')
                ->body('A customer with this account number already exists. Please use a different account number. / يوجد عميل برقم الحساب هذا مسبقاً. يرجى استخدام رقم حساب مختلف.')
                ->danger()
                ->send();

            $this->halt();
        }

        // Check if both name and account number exist (but for different customers)
        if ($existingCustomerByName && $existingCustomerByAccount && $existingCustomerByName->id !== $existingCustomerByAccount->id) {
            Notification::make()
                ->title('Duplicate Customer Data / بيانات العميل مكررة')
                ->body('Both the customer name and account number already exist for different customers. Please use different values. / اسم العميل ورقم الحساب موجودان لعملاء مختلفين. يرجى استخدام قيم مختلفة.')
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
