<?php

namespace Tests\Feature;

use App\Domains\Auth\Models\User;
use App\Domains\Games\Models\Game;
use App\Domains\Games\Services\GameLogService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GamesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function games_exists_and_runnable()
    {
        $games = Game::all();
        foreach ($games as $game) {
            $response = $this->get('/games/'.$game->id);

            $response->assertStatus(200);
        }
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

    /** @test */
    public function user_with_right_permission_can_work_with_game_in_backend()
    {
        $user = User::factory()->admin()->create();
        $this->actingAs($user);
        $response = $this->get('admin/games');
        $response->assertSessionHas('flash_danger', __('You do not have access to do that.'));

        $user->givePermissionTo('admin.access.games');
        $response = $this->get('admin/games');
        $response->assertStatus(200);
    }

    /** @test */
    public function game_log_ranking(){
        $game = Game::find(1);

        $log = resolve(GameLogService::class)->store($game, [
            'nickname' => 'test',
            'ip' => '127.0.0.1',
            'user_agent' => 'test',
        ]);
        $response = $this->get('/api/gameLogs/' . $log->id . '/ranking');
        $response->assertStatus(200);
        $response->assertSeeText(1);
    }
}
