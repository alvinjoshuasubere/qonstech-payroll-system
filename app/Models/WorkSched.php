<?php

namespace App\Models;

use Doctrine\DBAL\Schema\Table;
use Filament\Forms\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkSched extends Model
{
    use HasFactory;

    protected $table = 'worksched';

    protected $fillable = [
        'ScheduleName',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
        'CheckinOne',
        'CheckoutOne',
        'CheckinTwo',
        'CheckoutTwo',
    ];

    protected $casts = [
        'monday' => 'boolean',
        'tuesday' => 'boolean',
        'wednesday' => 'boolean',
        'thursday' => 'boolean',
        'friday' => 'boolean',
        'saturday' => 'boolean',
        'sunday' => 'boolean',
    ];
}
