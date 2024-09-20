<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biometrics extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_code',
        'fingerprint_data',
    ];

    // Optional: Define relationship with Employee model
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
