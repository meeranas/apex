<?php

namespace App\Filament\Resources\IssuerResource\Pages;

use App\Filament\Resources\IssuerResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CreateIssuer extends CreateRecord
{
    protected static string $resource = IssuerResource::class;

    public function mount(): void
    {
        abort_unless(Auth::user()?->hasRole('admin'), 403);
        
        parent::mount();
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Create the user account
        $user = User::create([
            'name' => $data['user_name'],
            'email' => $data['user_email'],
            'password' => Hash::make($data['password']),
        ]);

        // Assign the issuer role
        $user->assignRole('issuer');

        // Remove user fields from issuer data
        unset($data['user_name'], $data['user_email']);

        // Add user_id to issuer data
        $data['user_id'] = $user->id;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
