<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Filament\Resources\ProjectResource;
use App\Models\Employee;
use App\Livewire\Employees;

use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Pages\Page;

class ShowEmployeesPage extends Page
{
    protected static string $resource = EmployeeResource::class;

    protected static ?string $title = 'Assign Employees';

    protected static string $view = 'filament.resources.project-resource.pages.show-employees-page';

    protected function getWidgets(): array
    {
        return [
            Employees::class,
        ];
    }
   
    
}
