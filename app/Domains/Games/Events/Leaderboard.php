<?php

namespace App\Domains\Games\Events;

use App\Domains\Games\Http\Controllers\GameAPIController;
use App\Domains\Games\Models\Game;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Leaderboard implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected Game $game;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('games.'.$this->game->id);
    }

    public function broadcastWith()
    {
        return [
            'body' => resolve(GameAPIController::class)->leaderboard($this->game),
        ];
    }

    public function broadcastAs()
    {
        return 'leaderboard';
    }
}
