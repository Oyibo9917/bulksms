<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Messages;

class Messages extends Model
{
    use HasFactory;
    
    public function setActiveAttribute($active)
    {
        if($this->attributes['type'] == 'BIRTHDAY' && $active) {
            Messages::where('id', '!=', $this->id)->where('type', 'BIRTHDAY')->update(['active' => false]);
            // Messages::where('id', '=', $this->id)->where('type', 'BIRTHDAY')->update(['active' => true]);
            $this->attributes['active'] = true;
        } else {
            $this->attributes['active'] = $active;
        }
    }
}
