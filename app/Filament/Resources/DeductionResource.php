<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeductionResource\Pages;
use App\Filament\Resources\DeductionResource\RelationManagers;
use App\Models\Deduction;
use Filament\Forms;
use Filament\Forms\Form;
use App\Models\Employee;
use App\Models\pagibig;
use App\Models\philhealth;
use App\Models\sss;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeductionResource extends Resource
{
    protected static ?string $model = Deduction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = "Employee/Deduction/Earnings";

    protected static ?int $navigationSort = 2;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employeeID')
                ->label('Employee')
                ->options(Employee::all()->pluck('full_name', 'id'))
                ->live()
                ->afterStateUpdated(function (callable $set, $state, Get $get,) {
                    $employee = Employee::find($state);

                    if ($employee) {
                        $position = $employee->position;
                        if ($position) {
                            // Fetch SSS, PhilHealth, and Pag-IBIG based on the employee's position
                            $sss = sss::where('MinSalary', '<=', $position->MonthlySalary)
                                    ->where('MaxSalary', '>=', $position->MonthlySalary)
                                    ->first();
                            $philhealth = philhealth::where('MinSalary', '<=', $position->MonthlySalary)
                                                ->where('MaxSalary', '>=', $position->MonthlySalary)
                                                ->first();
                            $pagibig = pagibig::first(); // Assuming you fetch a single Pag-IBIG record

                            // Set the state for the contributions
                            $set('SSS_ID', $sss->id ?? null);
                            $set('PHILHEALTH_ID', $philhealth->id ?? null);
                            $set('PAGIBIG_ID', $pagibig->id ?? null);

                            // Calculate the monthly payments and round to 2 decimal places
                            $sssMonthlyPayment = $sss->EmployeeShare ?? 0;
                            $philhealthMonthlyPayment = $position->MonthlySalary <= 10000
                                ? ($philhealth->MonthlyRate ?? 0)
                                : ($position->MonthlySalary * ($philhealth->PremiumRate / 100));

                            $pagibigMonthlyPayment = $position->MonthlySalary < 1500
                                ? ($position->MonthlySalary * 0.01)
                                : ($position->MonthlySalary * 0.02);

                            $set('SSS_Monthly_Payment', number_format($sssMonthlyPayment, 2, '.', ''));
                            $set('PHILHEALTH_Monthly_Payment', number_format($philhealthMonthlyPayment, 2, '.', ''));
                            $set('Pagibig_Monthly_Payment', number_format($pagibigMonthlyPayment, 2, '.', ''));

                            self::updateTotals($get, $set);
                        }
                    }
                    }),
                    Hidden::make('SSS_ID'),
                    Hidden::make('PHILHEALTH_ID'),
                    Hidden::make('PAGIBIG_ID'),
                
                Forms\Components\TextInput::make('SSS_Monthly_Payment')
                    ->label('SSS Monthly Payment')
                    ->numeric()
                    ->readOnly()
                    ->required()
                    ->live()
                    ->afterStateHydrated(fn (Get $get, Set $set) => self::updateTotals($get, $set))
                    ,
                
                Forms\Components\TextInput::make('PHILHEALTH_Monthly_Payment')
                    ->label('PhilHealth Monthly Payment')
                    ->numeric()
                    ->readOnly()
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn (Get $get, Set $set) => self::updateTotals($get, $set)),
                
                Forms\Components\TextInput::make('Pagibig_Monthly_Payment')
                    ->label('Pag-IBIG Monthly Payment')
                    ->numeric()
                    ->readOnly()
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn (Get $get, Set $set) => self::updateTotals($get, $set)),
                
                Forms\Components\TextInput::make('CashAdvance')
                    ->label('Cash Advance')
                    ->numeric()
                    ->nullable()
                    ->live(debounce: 500)
                    ->afterStateUpdated(fn (Get $get, Set $set) => self::updateTotals($get, $set)),
                
                Forms\Components\TextInput::make('Undertime')
                    ->label('Undertime')
                    ->numeric()
                    ->nullable()
                    ->live(debounce: 500)
                    ->afterStateUpdated(fn (Get $get, Set $set) => self::updateTotals($get, $set)),
                
                Forms\Components\TextInput::make('SalaryAdjustment')
                    ->label('Salary Adjustment')
                    ->numeric()
                    ->nullable()
                    ->live(debounce: 500)
                    ->afterStateUpdated(fn (Get $get, Set $set) => self::updateTotals($get, $set)),
                
                Forms\Components\TextInput::make('Loan')
                    ->label('Loan')
                    ->numeric()
                    ->nullable()
                    ->live(debounce: 500)
                    ->afterStateUpdated(fn (Get $get, Set $set) => self::updateTotals($get, $set)),
                
                Forms\Components\TextInput::make('TotalDeduction')
                    ->label('Total Deduction')
                    ->numeric()
                    ->required()
                    ->readOnly(),
                
            ]);
    }

    public static function updateTotals(Get $get, Set $set): void
{
    // Retrieve the values of all relevant fields
    $sss = $get('SSS_Monthly_Payment') ?: 0;
    $philhealth = $get('PHILHEALTH_Monthly_Payment') ?: 0;
    $pagibig = $get('Pagibig_Monthly_Payment') ?: 0;
    $cashAdvance = $get('CashAdvance') ?: 0;
    $undertime = $get('Undertime') ?: 0;
    $salaryAdjustment = $get('SalaryAdjustment') ?: 0;
    $loan = $get('Loan') ?: 0;

    // Calculate the total deduction
    $totalDeduction = $sss + $philhealth + $pagibig + $cashAdvance + $undertime + $salaryAdjustment + $loan;

    // Update the TotalDeduction field
    $set('TotalDeduction', number_format($totalDeduction, 2, '.', ''));
}

    

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.full_name'),
                TextColumn::make('SSS_Monthly_Payment')->label('SSS Monthly Payment'),
                TextColumn::make('PHILHEALTH_Monthly_Payment')->label('PhilHealth Monthly Payment'),
                TextColumn::make('Pagibig_Monthly_Payment')->label('Pagibig Monthly Payment'),
                TextColumn::make('CashAdvance'),
                TextColumn::make('Undertime'),
                TextColumn::make('SalaryAdjustment'),
                TextColumn::make('Loan'),
                TextColumn::make('TotalDeduction'),
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
            'index' => Pages\ListDeductions::route('/'),
            'create' => Pages\CreateDeduction::route('/create'),
            'edit' => Pages\EditDeduction::route('/{record}/edit'),
        ];
    }
}
