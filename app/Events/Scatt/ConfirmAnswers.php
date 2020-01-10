<?php

namespace App\Events\Scatt;

use App\Model\User;
use App\Model\Scatt\Game;
use App\Model\Scatt\Round;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConfirmAnswers implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $round;
    private $user;
    private $confirm;

    /**
     * Create a new event instance.
     *
     * @param Round $round
     * @param User $user
     * @param bool $confirm
     */
    public function __construct(Round $round, User $user, bool $confirm)
    {
        $this->round = $round;
        $this->user = $user;
        $this->confirm = $confirm;
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
            'userId' => $this->user->id,
            'userName' => $this->user->name,
            'roundId' => $this->round->id,
            'accept' => $this->confirm
        ];
    }
}
