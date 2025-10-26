<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Feature extends Model
{
    //
    use SoftDeletes,HasUuids;

    protected $fillable = ['plan_id', 'name', 'value'];
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
