<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    //
    use HasUuids;

    protected $fillable = [
        'date',
        'purpose',
    ];

    public function  patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }
}
