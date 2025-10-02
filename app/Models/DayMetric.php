<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DayMetric extends Model
{
    protected $fillable = [
        'date','scheduled_ok','done_on_schedule','not_on_target','notes'
    ];

    protected $casts = [
        'date' => 'date',
        'notes' => 'array',
    ];
}
