<?php

namespace Tests\Feature;

use App\Domains\Games\Models\Game;
use App\Domains\Games\Services\GameLogService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class GamesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function snake_game_exists()
    {
        $this->assertDatabaseHas('games', [
            'id' => 1,
            'title' => 'snake',
        ]);
        $response = $this->get('/games/1');

        $response->assertStatus(200);
    }

    /** @test */
    public function create_game_log()
    {
        $response = $this->post('/api/games/1', [
            'nickname' => 'test',
        ]);

        $response->assertStatus(201);
    }

    /** @test */
    public function update_game_log()
    {
        $game = Game::find(1);
        $log = resolve(GameLogService::class)->store($game, [
            'nickname' => 'test',
            'ip' => '127.0.0.1',
            'user_agent' => 'test',
        ]);
        $response = $this->post('/api/gameLogs/' . $log->id, [
            'score' => 10,
            'duration' => 10,
        ], ['User-Agent' => 'test']);

        $response->assertStatus(200);
    }

    /** @test */
    public function leaderboard_work()
    {
        $game = Game::find(1);

        $log = resolve(GameLogService::class)->store($game, [
            'nickname' => 'test',
            'ip' => '127.0.0.1',
            'user_agent' => 'test',
        ]);
        $response = $this->get('/api/games/' . $game->id . '/leaderboard');

        $response->assertStatus(200);
        $response->assertJson([
            $log->toArray(),
        ]);
    }
}
