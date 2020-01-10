<?php

namespace App\Events\Scatt;

use App\Http\Resources\Scatt\AnswerResource;
use App\Model\Scatt\Game;
use App\Model\Scatt\Round;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AnswersList implements ShouldBroadcast
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
     * @return \Illuminate\Broadcasting\Channel|array
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
        return AnswerResource::collection($this->round->answers)->resolve();
    }
}
