<?php

namespace App\Filament\Resources\CityResource\Pages;

use App\Filament\Resources\CityResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateCity extends CreateRecord
{
    protected static string $resource = CityResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        try {
            return static::getModel()::create($data);
        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            Notification::make()
                ->title('City Already Exists')
                ->body('A city with this name already exists. Please choose a different name.')
                ->danger()
                ->send();

            // Don't re-throw the exception, instead halt the process
            $this->halt();
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
