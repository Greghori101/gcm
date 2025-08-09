<?php

namespace App\Jobs;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExpireOldTicketsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        Ticket::whereDate('day', '<', Carbon::today())
            ->where('status', '==', 'pending')
            ->chunk(100, function ($tickets) {
                foreach ($tickets as $ticket) {
                    $ticket->update(['status' => 'expired']);
                }
            });
    }
}
