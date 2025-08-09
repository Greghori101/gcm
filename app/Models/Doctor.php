<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Doctor extends Model
{
    //
    use HasUuids, HasTranslations;

    public array $translatable = ['specialty'];

    protected $fillable = [
        'specialty',
        'national_order_number',
    ];

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
