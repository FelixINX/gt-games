<?php

namespace App\Events\Scatt;

use App\Model\User;
use App\Model\Scatt\Game;
use App\Model\Scatt\Round;
use Illuminate\Broadcasting\Channel;
use App\Http\Resources\Scatt\RoundResource;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChangeState implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $game;
    public $responsibleUser;
    public $newState;
    public $transitionTime;
    public $newRound;

    /**
     * Create a new event instance.
     *
     * @param Game $game
     * @param User $responsibleUser
     * @param string $newState
     * @param int $transitionTime
     * @param Round $newRound
     */
    public function __construct(Game $game, User $responsibleUser, string $newState, int $transitionTime, Round $newRound)
    {
        $this->game = $game;
        $this->responsibleUser = $responsibleUser;
        $this->newState = $newState;
        $this->transitionTime = $transitionTime;
        $this->newRound = $newRound;
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
        return new Channel('scatt-' . $this->game->id);
    }

    /**
     * Broadcast content
     */
    public function broadcastWith()
    {
        return [
            'responsibleUser' => $this->responsibleUser->name,
            'newState' => $this->newState,
            'transitionTime' => $this->transitionTime,
            'newRound' => RoundResource::make($this->newRound)->resolve()
        ];
    }
}
