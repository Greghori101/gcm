<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class TestRequest extends Model
{
    //
    use HasUuids;

    protected $fillable = [
        'nb',
        'date',
        'past_medical_history',
        'visit_purpose',
        'conclusion',
        'requests',
    ];

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function  patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
