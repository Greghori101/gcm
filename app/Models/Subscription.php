<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Enums\SubscriptionStatus;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Subscription extends Model
{

    use SoftDeletes,HasUuids;

    protected $fillable = [
        'user_id',
        'plan_id',
        'start_date',
        'end_date',
        'status'
    ];

    protected $casts = [
        'status' => SubscriptionStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function isActive()
    {
        return $this->status === SubscriptionStatus::Active
            && Carbon::now()->between($this->start_date, $this->end_date);
    }
}
