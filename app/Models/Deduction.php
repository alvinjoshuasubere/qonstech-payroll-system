<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    use HasFactory;

    protected $table = 'deductions';

    // Allow mass assignment for the specified attributes
    protected $fillable = [
        'employeeID',
        'SSS_ID',
        'PHILHEALTH_ID',
        'PAGIBIG_ID',
        'SSS_Monthly_Payment',
        'PHILHEALTH_Monthly_Payment',
        'Pagibig_Monthly_Payment',
        'CashAdvance',
        'Undertime',
        'SalaryAdjustment',
        'Loan',
        'TotalDeduction',
    ];

    // Define the relationships
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employeeID');
    }

    public function sss()
    {
        return $this->belongsTo(SSS::class, 'SSS_ID');
    }

    public function philhealth()
    {
        return $this->belongsTo(PhilHealth::class, 'PHILHEALTH_ID');
    }

    public function pagibig()
    {
        return $this->belongsTo(Pagibig::class, 'PAGIBIG_ID');
    }
}
