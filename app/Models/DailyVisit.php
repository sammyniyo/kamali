<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyVisit extends Model
{
    protected $fillable = [
        'date',
        'visits',
        'unique_visitors',
    ];

    protected $casts = [
        'date' => 'date',
        'visits' => 'integer',
        'unique_visitors' => 'integer',
    ];
}
