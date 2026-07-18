<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_number',
        'bus_name',
        'bus_type',
        'total_seats',
        'status',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}