<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Tables\Actions\BulkAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Collection;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Relationship;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = "Employee/Deduction/Earnings";

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Name')
                ->schema([
                    TextInput::make('first_name')
                    ->label('First Name')
                    ->required(fn (string $context) => $context === 'create')
                    ->unique(ignoreRecord: true)
                    ->rules('regex:/^[^\d]*$/'),

                    TextInput::make('middle_name')
                    ->label('Middle Name')
                    ->rules('regex:/^[^\d]*$/'),
                    

                    TextInput::make('last_name')
                    ->label('last Name')
                    ->required(fn (string $context) => $context === 'create')
                    ->rules('regex:/^[^\d]*$/'),

                    TextInput::make('attendance_code')
                    ->label('Attendance Code')
                    ->required(fn (string $context) => $context === 'create')
                    ])->columns(3)->collapsible(true),

                Section::make('Address')
                ->schema([
                    Select::make('province')
                            ->label('Province')
                            ->required(fn (string $context) => $context === 'create')
                            ->options([
                            'South Cotabato' => 'South Cotabato',
                            ])->native(false),

                    Select::make('city')
                        ->label('City')
                        ->required(fn (string $context) => $context === 'create')
                        ->options([
                            'Koronadal City' => 'Koronadal City',
                            'Polomolok' => 'Polomolok',
                            'Tupi' => 'Tupi',
                            'Tantangan' => 'Tantangan',
                            'Surallah' => 'Surallah',
                            'Lake Sebu' => 'Lake Sebu',
                            'Banga' => 'Banga',
                        ])->native(false),

                    Select::make('barangay')
                        ->label('Barangay')
                        ->required(fn (string $context) => $context === 'create')
                        ->options([
                            'Barangay Zone III' => 'Barangay Zone III',
                            'Cannery Site' => 'Cannery Site',
                            'Poblacion' => 'Poblacion',
                            'Crossing Rubber' => 'Crossing Rubber',
                            'Liberty' => 'Liberty',
                            'Lamian' => 'Lamian',
                            'Rizal' => 'Rizal',
                        ])->native(false),

                    Select::make('street')
                        ->label('Street')
                        ->required(fn (string $context) => $context === 'create')
                        ->options([
                            'Sanchez St.' => 'Sanchez St.',
                            'Roxas St.' => 'Roxas St.',
                            'GenSan Drive' => 'GenSan Drive',
                            'Polomolok Road' => 'Polomolok Road',
                            'Apolinario Mabini St.' => 'Apolinario Mabini St.',
                            'Bonifacio St.' => 'Bonifacio St.',
                        ])->native(false),
                ])->columns(4)->collapsible(true),



                Section::make('Position/Project/Work Schedule')
                ->schema([
                    Select::make('position_id')
                            ->label('Position')
                            ->required(fn (string $context) => $context === 'create')
                            ->relationship('position', 'PositionName')
                            ->native(false),

                    Select::make('project_id')
                        ->label('Project')
                        ->required(fn (string $context) => $context === 'create')
                        ->relationship('project', 'ProjectName')
                        ->native(false)
                        ->reactive()
                        ->afterStateUpdated(fn ($state, callable $set) => $set('status', $state ? 'Assigned' : 'Available'))
                        ,

                    Select::make('schedule_id')
                        ->label('Work Schedule')
                        ->required(fn (string $context) => $context === 'create')
                        ->relationship('schedule', 'ScheduleName')
                        ->native(false),

                    Select::make('overtime_id')
                        ->label('Overtime')
                        ->relationship('overtime', 'Reason')
                        ->native(false),
                ])->columns(4)->collapsible(true),


                Section::make('Contact Number/Status')
                ->schema([

                    TextInput::make('contact_number')
                    ->label('Contact Number')
                    ->required(fn (string $context) => $context === 'create')
                    ->unique(ignoreRecord: true)
                    ->rules('regex:/^[\d]*$/'),

                    Select::make('status')
                        ->label('Status')
                        ->required(fn (string $context) => $context === 'create')
                        ->options([
                            'Assigned' => 'Assigned',
                            'Available' => 'Available',

                        ]),

                    
                        Select::make('employment_type')
                        ->label('Employment Type')
                        ->required(fn (string $context) => $context === 'create')
                        ->options([
                            'Regular' => 'Regular',
                            'Project Based' => 'Project Based',
                        ])->native(false),


                ])->columns(3)->collapsible(true)



                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                ->label('Name')
                ->formatStateUsing(fn ($record) => $record->first_name . ' ' . ($record->middle_name ? $record->middle_name . ' ' : '') . $record->last_name)
                ->searchable(['first_name', 'middle_name', 'last_name'])
                ,

                TextColumn::make('full_address')
                ->label('Address')
                ->formatStateUsing(fn ($record) => $record->full_address),

                TextColumn::make('position.PositionName'),
                TextColumn::make('project.ProjectName'),
                TextColumn::make('schedule.ScheduleName'),
                TextColumn::make('overtime.Reason'),
                TextColumn::make('contact_number'),
                TextColumn::make('status'),

            ])

            ->filters([
                SelectFilter::make('first_name')
                ->label('Filter by Employee First Name')
                ->options(
                    \App\Models\Employee::query()
                        ->pluck('first_name', 'first_name')
                        ->toArray()
                )
                ->searchable()
                ->multiple()
                ->preload(),

                SelectFilter::make('project_id')
                ->label('Filter by Project')
                ->relationship('project', 'ProjectName')
                ->searchable()
                ->multiple()
                ->preload()
                ,

                SelectFilter::make('position_id')
                ->label('Filter by Position')
                ->relationship('position', 'PositionName')
                ->searchable()
                ->multiple()
                ->preload(),

                SelectFilter::make('overtime_id')
                ->label('Filter by Overtime')
                ->relationship('overtime', 'Reason')
                ->searchable()
                ->multiple()
                ->preload(),

                SelectFilter::make('status')
                ->label('Filter by Status')
                ->options([
                    'Asigned' => 'Asigned',
                    'Available' => 'Available',

                ])
                ->searchable()
                ->preload(),

            ])//end of filter

            ->actions([
                Tables\Actions\EditAction::make(),
            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),

                BulkAction::make('assign_to_project')
                ->label('Assign to Project')
                ->form([
                    Select::make('project_id')
                        ->label('Project')
                        ->relationship('project', 'ProjectName')
                        ->required()
                ])
                ->action(function (array $data, Collection $records) {
                    $projectId = $data['project_id'];

                    foreach ($records as $record) {
                        $record->update(['project_id' => $projectId]);
                    }
                })
                ->deselectRecordsAfterCompletion()
                ->requiresConfirmation(),


                BulkAction::make('assign_to_position')
                ->label('Assign to Position')
                ->form([
                    Select::make('project_id')
                        ->label('Project')
                        ->relationship('project', 'ProjectName')
                        ->required()
                ])
                ->action(function (array $data, Collection $records) {
                    $projectId = $data['project_id'];

                    foreach ($records as $record) {
                        $record->update(['project_id' => $projectId]);
                    }
                })
                ->deselectRecordsAfterCompletion()
                ->requiresConfirmation(),


                BulkAction::make('assign_to_overtime')
                ->label('Assign to Overtime')
                ->form([
                    Select::make('overtime_id')
                        ->label('Overtime')
                        ->relationship('overtime', 'Reason')
                        ->required()
                ])
                ->action(function (array $data, Collection $records) {
                    $projectId = $data['overtime_id'];

                    foreach ($records as $record) {
                        $record->update(['overtime_id' => $projectId]);
                    }
                })
                ->deselectRecordsAfterCompletion()
                ->requiresConfirmation()
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
