<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pagibig extends Model
{
    use HasFactory;

    protected $table = 'pagibig';

    protected $fillable = [
        'MonthlySalary',
        'Rate',
    ];
}
