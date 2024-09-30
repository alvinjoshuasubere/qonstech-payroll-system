<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Livewire\Employees;

class ShowAvailableEmployees extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.show-available-employees';

    protected static ?string $navigationGroup = "Projects/Assign";

    protected static ?string $title = 'Add Employees to Project';


    protected function getWidgets(): array
    {
        return [
            Employees::class,
        ];
    }

    
}