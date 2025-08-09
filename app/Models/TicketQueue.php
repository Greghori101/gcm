<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketQueue extends Model
{
    //
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
