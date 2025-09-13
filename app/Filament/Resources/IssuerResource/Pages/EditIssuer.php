<?php

namespace App\Filament\Resources\IssuerResource\Pages;

use App\Filament\Resources\IssuerResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class EditIssuer extends EditRecord
{
    protected static string $resource = IssuerResource::class;

    public function mount(int | string $record): void
    {
        abort_unless(Auth::user()?->hasRole('admin'), 403);
        
        parent::mount($record);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Add user data to form
        if ($this->record->user) {
            $data['user_name'] = $this->record->user->name;
            $data['user_email'] = $this->record->user->email;
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Update user account
        if ($this->record->user) {
            $this->record->user->update([
                'name' => $data['user_name'],
                'email' => $data['user_email'],
            ]);

            // Update password if provided
            if (!empty($data['password'])) {
                $this->record->user->update([
                    'password' => Hash::make($data['password']),
                ]);
            }
        }

        // Remove user fields from issuer data
        unset($data['user_name'], $data['user_email']);

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
