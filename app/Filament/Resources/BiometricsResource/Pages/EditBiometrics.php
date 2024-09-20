<?php

namespace App\Filament\Resources\BiometricsResource\Pages;

use App\Filament\Resources\BiometricsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBiometrics extends EditRecord
{
    protected static string $resource = BiometricsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
