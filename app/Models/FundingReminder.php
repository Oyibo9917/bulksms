<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundingReminder extends Model
{
    use HasFactory;

    protected $fillable = ['is_sent'];
}
