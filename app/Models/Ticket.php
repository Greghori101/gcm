<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Ticket extends Model
{
    use HasUuids;
    protected $fillable = [
        'patient_id',
        'queue_id',
        'number',
        'ticket_date',
        'status'
    ];
    public $incrementing = false;
    protected $keyType = 'string';
    protected $casts = [
        'status' => TicketStatus::class,
        'ticket_date' => 'date'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function queue()
    {
        return $this->belongsTo(TicketQueue::class);
    }

    public static function createTicket($patientId, $queueId)
    {
        $today = Carbon::today();
        $lastTicket = self::where('ticket_date', $today)
            ->where('queue_id', $queueId)
            ->orderByDesc('number')
            ->first();

        $nextNumber = $lastTicket ? $lastTicket->number + 1 : 1;

        return self::create([
            'id' => (string) Str::uuid(),
            'patient_id' => $patientId,
            'queue_id' => $queueId,
            'number' => $nextNumber,
            'ticket_date' => $today,
            'status' => TicketStatus::Pending
        ]);
    }

    public static function latestTicket($queueId)
    {
        return self::where('queue_id', $queueId)
            ->where('ticket_date', Carbon::today())
            ->latest('created_at')
            ->first();
    }

    public static function nextQueueTicket($queueId)
    {
        return self::where('queue_id', $queueId)
            ->where('ticket_date', Carbon::today())
            ->where('status', TicketStatus::Pending)
            ->orderBy('number')
            ->first();
    }

    public static function nextTicket()
    {
        return self::where('ticket_date', now()->toDateString())
            ->where('status', TicketStatus::Pending)
            ->whereHas('queue')
            ->with('queue')
            ->join('queues', 'tickets.queue_id', '=', 'queues.id')
            ->orderBy('queues.priority', 'asc')
            ->orderBy('tickets.number', 'asc')
            ->select('tickets.*')
            ->first();
    }

    public static function waitingCount($queueId)
    {
        return self::where('queue_id', $queueId)
            ->where('ticket_date', Carbon::today())
            ->where('status', TicketStatus::Pending)
            ->count();
    }

    public static function totalWaitingCount()
    {
        return self::where('ticket_date', Carbon::today())
            ->where('status', TicketStatus::Pending)
            ->count();
    }
}
