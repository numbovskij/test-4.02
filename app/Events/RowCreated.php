<?php

namespace App\Events;

use App\Domain\Excel\Models\Excel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RowCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly Excel $row,
    )
    {
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('rows'),
        ];
    }
}
