<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadStatus extends Model
{
    use HasFactory;

    protected $fillable = ['mobile_numbers', 'email', 'birth_date'];
}
