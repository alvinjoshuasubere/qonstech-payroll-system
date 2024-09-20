<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BiometricsResource\Pages;
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
        ]);
        // ->actions([
        //     Action::make('captureFingerprint')
        //         ->label('New Biometric')
        //         ->url(route('filament.pages.biometric-capture')), 
        // ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('attendance_code'),
                ImageColumn::make('fingerprint_data')->label('Fingerprint')
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
