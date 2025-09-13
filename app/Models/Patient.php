<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Patient extends Model
{
    //
    use HasUuids, HasTranslations;

    public array $translatable = ['firstname', 'lastname'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'birthdate',
        'phone_number',
        'blood_type',
        'gender',
        'medical_history'
    ];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'medical_history' => 'array',
        ];
    }
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
