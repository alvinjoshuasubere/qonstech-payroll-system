<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\Pages\ShowEmployeesPage;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Filament\Resources\ProjectResource\RelationManagers\EmployeesRelationManager;
use App\Models\Project;
use Filament\Forms;
use App\Filament\Widgets\Employees;
use App\Models\Employee;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Facades\Filament;
use Filament\Forms\Form;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 4;
    protected static ?string $navigationGroup = "Projects/Assign";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    Section::make('Project Information')
                    ->schema([
                        TextInput::make('ProjectName')
                        ->label('Project Name')
                        ->required(fn (string $context) => $context === 'create')
                        ->unique(ignoreRecord: true)
                        ->rules('regex:/^[^\d]*$/'),

                    
                    Section::make('Location')
                    ->schema([
                        Select::make('PR_Province')
                                ->label('Province')
                                ->required(fn (string $context) => $context === 'create')
                                ->options([
                                'South Cotabato' => 'South Cotabato',
                                ]),

                        Select::make('PR_City')
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
                            ]),

                        Select::make('PR_Barangay')
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
                            ]),

                        Select::make('PR_Street')
                            ->label('Street')
                            ->required(fn (string $context) => $context === 'create')
                            ->options([
                                'Sanchez St.' => 'Sanchez St.',
                                'Roxas St.' => 'Roxas St.',
                                'GenSan Drive' => 'GenSan Drive',
                                'Polomolok Road' => 'Polomolok Road',
                                'Apolinario Mabini St.' => 'Apolinario Mabini St.',
                                'Bonifacio St.' => 'Bonifacio St.',
                            ]),

                    ])
                    ->columns(4)
                    ->collapsible(true),

                    Section::make('Date')
                    ->schema([

                        DatePicker::make('StartDate')
                        ->required(fn (string $context) => $context === 'create'),

                        DatePicker::make('EndDate')
                        ->required(fn (string $context) => $context === 'create')
                        ->after('StartDate')
                    ])
                    ->columns(2)
                    ->collapsible(true),
                ])->collapsible(true)->collapsed(true),
                

            ]);
            
            
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ProjectName')->searchable(),
                TextColumn::make('PR_Province')
                ->label('Province')
                ->searchable(),
                TextColumn::make('PR_City')->label('City'),
                TextColumn::make('PR_Barangay')->label('Barangay'),
                TextColumn::make('PR_Street')->label('Street'),
                TextColumn::make('StartDate'),
                TextColumn::make('EndDate'),
            ])
            ->filters([
                
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    

    public static function getRelations(): array
    {
        return [
            EmployeesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            
        ];
    }


}
