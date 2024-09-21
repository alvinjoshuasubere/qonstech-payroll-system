<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceResource\Pages;
use App\Filament\Resources\AttendanceResource\RelationManagers;
use App\Models\Attendance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $title = 'Attendance';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.full_name')
                ->label('Employee Name')
                ->sortable(),

                TextColumn::make('Checkin_One')
                ->label('Morning Check-in')
                ->sortable(),

                TextColumn::make('Checkout_One')
                ->label('Morning Checkout')
                ->sortable(),

                TextColumn::make('Checkin_Two')
                ->label('Afternoon Check-in')
                ->sortable(),

                TextColumn::make('Checkout_Two')
                ->label('Afternoon Checkout')
                ->sortable(),

                TextColumn::make('Date')
                ->label('Date')
                ->sortable(),

                TextColumn::make('Total_Hours')
                ->label('Total Hours')
                ->sortable()
            
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([

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
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}
