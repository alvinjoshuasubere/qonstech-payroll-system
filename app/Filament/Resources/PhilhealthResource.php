<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PhilhealthResource\Pages;
use App\Filament\Resources\PhilhealthResource\RelationManagers;
use App\Models\philhealth;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class PhilhealthResource extends Resource
{
    protected static ?string $model = philhealth::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = "Contribution";

    protected static ?string $title = 'PHILHEALTH';

    protected static ?string $breadcrumb = "PHILHEALTH";

    protected static ?string $navigationLabel = 'PHILHEALTH';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('MinSalary')
                ->label('Minimum Salary')
                ->required(fn (string $context) => $context === 'create')
                ->numeric()
                ->lte('MaxSalary')
                ->unique(ignoreRecord: true)
                ,

                TextInput::make('MaxSalary')
                ->label('Maximum Salary')
                ->required(fn (string $context) => $context === 'create')
                ->numeric()
                ->gte('MinSalary')
                ->unique(ignoreRecord: true)
                ,

                TextInput::make('PremiumRate')
                ->required(fn (string $context) => $context === 'create')
                ->numeric()
                ,

                TextInput::make('MonthlyRate')
                ->required(fn (string $context) => $context === 'create')
                ->numeric()
                ,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                ->label('SSS ID')
                ->searchable(),

                TextColumn::make('MinSalary')
                ->searchable(),

                TextColumn::make('MaxSalary')
                ->searchable(),
                
                TextColumn::make('PremiumRate'),
                TextColumn::make('MonthlyRate'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    
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
            'index' => Pages\ListPhilhealths::route('/'),
            'create' => Pages\CreatePhilhealth::route('/create'),
            'edit' => Pages\EditPhilhealth::route('/{record}/edit'),
        ];
    }
}
