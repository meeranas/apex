<?php

namespace App\Filament\Resources\CityResource\Pages;

use App\Filament\Resources\CityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditCity extends EditRecord
{
    protected static string $resource = CityResource::class;

    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        try {
            $record->update($data);
            return $record;
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
