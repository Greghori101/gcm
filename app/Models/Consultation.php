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

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
    
    public function testRequests()
    {
        return $this->hasMany(TestRequest::class);
    }
    
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
