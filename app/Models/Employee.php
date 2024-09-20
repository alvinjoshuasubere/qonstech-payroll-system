<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;


    protected $table = 'employees';

    protected $fillable = [
        'position_id',
        'overtime_id',
        'project_id',
        'schedule_id',
        'first_name',
        'middle_name',
        'last_name',
        'employment_type',
        'street',
        'barangay',
        'city',
        'province',
        'contact_number',
        'status',
        'attendance_code'
    ];

    // Defining the relationships

    /**
     * Get the position associated with the employee.
     */
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Get the project associated with the employee.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the schedule associated with the employee.
     */
    public function schedule()
    {
        return $this->belongsTo(WorkSched::class);
    }

    public function overtime()
    {
        return $this->belongsTo(Overtime::class, 'overtime_id');
    }

    /**
     * Get the full name of the employee.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name}";
    }

    public function getFullAddressAttribute()
{
    return trim("{$this->street} {$this->barangay} {$this->city} {$this->province}");
}


    public function attendanceRecords()
    {
        return $this->hasMany(Attendance::class, 'employee_id');
    }
}
