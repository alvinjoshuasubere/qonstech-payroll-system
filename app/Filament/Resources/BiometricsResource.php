<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BiometricsResource\Pages;
// use App\Filament\Resources\CaptureImage\Pages;
use App\Models\Biometrics;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
// use Filament\Forms\Components\Action;
use Filament\Forms\Components\Hidden;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class BiometricsResource extends Resource
{
    protected static ?string $model = Biometrics::class;

    protected static ?string $navigationIcon = 'heroicon-o-finger-print';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('attendance_code')
                    ->required(),
                Forms\Components\Textarea::make('biometric_data')
                    ->label('Biometric Data')
                    ->disabled()  // Display-only in admin panel
                    ->required(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('attendance_code')
                    ->label('Attendance Code'),
                Tables\Columns\TextColumn::make('biometric_data')
                    ->label('Biometric Data')
                    ->limit(50),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime(),
            ]);
    }

   
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBiometrics::route('/'),
            'create' => Pages\CreateBiometrics::route('/create'),
            'edit' => Pages\EditBiometrics::route('/{record}/edit'),
        ];
    }
}
