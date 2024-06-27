<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Scheduler extends Model
{
    use HasFactory;


    public function contact(): HasMany 
    {
        return $this->hasMany(Contacts::class, 'id');
    }

    public function message(): HasOne 
    {
        return $this->hasOne(Messages::class, 'id');
    }

    public function setScheduledContactAttribute($contacts)
    {
        $this->attributes['scheduled_contact'] = json_encode($contacts);
    }
}
