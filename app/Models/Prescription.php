<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    //
    use HasUuids;

    protected $fillable = [
        'nb',
        'date',
    ];

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function  patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function  medicines()
    {
        return $this->belongsToMany(Medicine::class)->with([
            'form',
            'dosage',
            'quantity',
            'unit',
            'posology',
            'conditions',
        ]);
    }
}
