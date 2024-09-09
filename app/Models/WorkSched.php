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
        'Days',
        'CheckinOne',
        'CheckoutOne',
        'CheckinTwo',
        'CheckoutTwo',
    ];
}
