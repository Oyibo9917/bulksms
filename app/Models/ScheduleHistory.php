<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleHistory extends Model
{
    use HasFactory;

    protected $fillable = ['contacts', 'message', 'delivered_at', 'frequency', 'status'];
}
