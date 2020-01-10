<?php

namespace App\Events\Scatt;

use App\Model\Scatt\Game;
use App\Model\Scatt\Round;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendAnswers implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $round;

    /**
     * Create a new event instance.
     *
     * @param Round $round
     */
    public function __construct(Round $round)
    {
        $this->round = $round;
    }

    /**
     * The name of the queue on which to place the event.
     *
     * @var string
     */
    public $broadcastQueue = 'pusher';

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('scatt-' . $this->round->game->id);
    }

    /**
     * Broadcast content
     */
    public function broadcastWith()
    {
        return [
            'roundId' => $this->round->id
        ];
    }
}
