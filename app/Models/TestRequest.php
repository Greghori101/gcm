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
        'past_medical_history',
        'visit_purpose',
        'conclusion',
        'requests',
        'date',
        'purpose',
    ];
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function  patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }
}
