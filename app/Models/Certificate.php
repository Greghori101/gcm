<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    //
    use HasUuids;

    protected $fillable = [
        'nb',
        'period',
        'signature',
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
