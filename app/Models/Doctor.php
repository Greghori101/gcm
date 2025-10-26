<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Doctor extends Model implements HasMedia
{
    //
    use HasUuids, HasTranslations, InteractsWithMedia;

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


    public function logo()
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', 'logo');
    }
}
