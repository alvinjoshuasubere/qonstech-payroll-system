<?php

namespace App\Filament\Resources\OvertimeResource\RelationManagers;

use App\Filament\Pages\ViewEmployeeOvertime;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeesRelationManager extends RelationManager
{
    protected static string $relationship = 'employees';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('first_name')
            ->columns([
                Tables\Columns\TextColumn::make('full_name') 
                ->label('Name')
                ->formatStateUsing(fn ($record) => $record->first_name . ' ' . ($record->middle_name ? $record->middle_name . ' ' : '') . $record->last_name)
                ->sortable()
                ->searchable(),

                Tables\Columns\TextColumn::make('position.PositionName'),

                Tables\Columns\TextColumn::make('project.ProjectName'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\Action::make('customPage')
                ->label('Assign Employees')
                ->url(ViewEmployeeOvertime::getUrl())
            ])
            ->actions([

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('remove_from_project')
                        ->label('Remove from Overtime')
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->update([
                                    'overtime_id' => null,  // Remove project assignment by setting project_id to null
                                ]);
                            }
                        })
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation(),
                ]),
            ]);
    }
}
