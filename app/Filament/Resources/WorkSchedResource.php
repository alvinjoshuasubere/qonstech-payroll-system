<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkSchedResource\Pages;
use App\Filament\Resources\WorkSchedResource\RelationManagers;
use App\Models\WorkSched;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Table;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WorkSchedResource extends Resource
{
    protected static ?string $model = WorkSched::class;

    protected static ?string $navigationLabel = 'Work Schedule';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $title = 'Work Schedules';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('ScheduleName')
                ->label('Schedule Name')
                ->required(fn (string $context) => $context === 'create')
                ->unique(ignoreRecord: true)
                ->rules('regex:/^[^\d]*$/'),

                Section::make('Days')
                ->schema([
                    Toggle::make('monday'),
                    Toggle::make('tuesday'),
                    Toggle::make('wednesday'),
                    Toggle::make('thursday'),
                    Toggle::make('friday'),
                    Toggle::make('saturday'),
                    Toggle::make('sunday'),
                ])->compact()->columns(7)->collapsible(true),
            
                Section::make('Morning Shift')
                ->schema([
                    TextInput::make('CheckinOne')
                        ->label('Check-in Time')
                        ->type('time')
                        ->required(fn (string $context) => $context === 'create'),
                    
                    TextInput::make('CheckoutOne')
                        ->label('Check-out Time')
                        ->type('time')
                        ->after('CheckinOne')
                        ->required(fn (string $context) => $context === 'create'),

                ])->collapsible(true),
            
            Section::make('Afternoon Shift')
                ->schema([
                    TextInput::make('CheckinTwo')
                        ->label('Check-in Time')
                        ->type('time')
                        ->required(fn (string $context) => $context === 'create'),
                    
                    TextInput::make('CheckoutTwo')
                        ->label('Check-out Time')
                        ->type('time')
                        ->after('CheckinTwo')
                        ->required(fn (string $context) => $context === 'create'),
                ])->collapsible(true),


            ]);        
    }

    public static function table(Table $table): Table
    {   
        return $table
            ->columns([
                TextColumn::make('ScheduleName')->searchable(),
                IconColumn::make('monday')->boolean()->label('Monday'),
                IconColumn::make('tuesday')->boolean()->label('Tuesday'),
                IconColumn::make('wednesday')->boolean()->label('Wednesday'),
                IconColumn::make('thursday')->boolean()->label('Thursday'),
                IconColumn::make('friday')->boolean()->label('Friday'),
                IconColumn::make('saturday')->boolean()->label('Saturday'),
                IconColumn::make('sunday')->boolean()->label('Sunday'),
                TextColumn::make('CheckinOne'),
                TextColumn::make('CheckoutOne'),
                TextColumn::make('CheckinTwo'),
                TextColumn::make('CheckoutTwo'),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWorkScheds::route('/'),
            'create' => Pages\CreateWorkSched::route('/create'),
            'edit' => Pages\EditWorkSched::route('/{record}/edit'),
        ];
    }
}
