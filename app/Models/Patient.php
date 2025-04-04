<?php

namespace App\Models;

use Faker\Provider\Address;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    //
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [];

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
    
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
    
    public function testRequests()
    {
        return $this->hasMany(TestRequest::class);
    }
}
