<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Plan extends Model
{
    //
    use SoftDeletes,HasUuids;

    protected $fillable = ['name', 'price', 'billing_cycle'];
    public function features()
    {
        return $this->hasMany(Feature::class);
    }
}
