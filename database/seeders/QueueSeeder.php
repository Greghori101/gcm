<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Queue;
use App\Models\TicketQueue;
use Illuminate\Support\Str;

class QueueSeeder extends Seeder
{
    public function run()
    {
        $queues = [
            ['name' => 'Higher', 'priority' => 1],
            ['name' => 'Urgent', 'priority' => 2],
            ['name' => 'Normal', 'priority' => 3],
        ];

        foreach ($queues as $queue) {
            TicketQueue::create([
                'id' => (string) Str::uuid(),
                'name' => $queue['name'],
                'priority' => $queue['priority'],
            ]);
        }
    }
}
