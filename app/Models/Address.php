<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //
    use HasUuids;

    protected $fillable = [
        'latitude',
        'longitude',
        'formatted_address',
        'country',
        'state',
        'commune',
        'city',
    ];

    public function addressable()
    {
        return $this->morphTo();
    }
}
