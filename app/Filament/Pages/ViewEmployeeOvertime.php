<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;


use App\Livewire\EmployeesOvertime;

class ViewEmployeeOvertime extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.view-employee-overtime';

    protected static ?string $title = 'Add Employees to Overtime';

    protected static ?string $navigationGroup = "Overtime/Assign";


    protected function getWidgets(): array
    {
        return [
            EmployeesOvertime::class,
        ];

        
    }
}
