<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    use HasFactory;

    
    protected $table = 'overtime';

    protected $fillable = [
        'Reason',
        'Checkin',
        'Checkout',
        'Date',
        'Status',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

}
