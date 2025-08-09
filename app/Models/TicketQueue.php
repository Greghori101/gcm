<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class TicketQueue extends Model
{
    //
    use HasUuids;

    protected $fillable = ['name', 'priority'];
    public $incrementing = false;
    protected $keyType = 'string';

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function waitingCount()
    {
        return $this->tickets()
            ->where('status', 'pending')
            ->count();
    }
}
