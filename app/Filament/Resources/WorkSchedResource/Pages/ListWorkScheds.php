<?php

namespace App\Filament\Resources\WorkSchedResource\Pages;

use App\Filament\Resources\WorkSchedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWorkScheds extends ListRecords
{
    protected static ?string $title = 'Work Schedules';
    protected static string $resource = WorkSchedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
