<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contacts extends Model
{
    protected $fillable = ['name', 'gender', 'mobile_no', 'email', 'birth_date', 'address', 'active', 'contact_group_id'];

    use HasFactory;

    public function group(): BelongsTo
    {
        return $this->belongsTo(Groups::class, 'contact_group_id');
    }

     // Define default ordering
    // protected static function booted()
    // {
    //     // Order by created_at descending
    //     static::addGlobalScope('order', function ($query) {
    //         $query->orderBy('created_at', 'desc');
    //     });
    // }
}
