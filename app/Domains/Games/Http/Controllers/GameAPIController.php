<?php

namespace App\Domains\Games\Http\Controllers;

use App\Domains\Games\Events\Leaderboard;
use App\Domains\Games\Http\Requests\StoreGameLogRequest;
use App\Domains\Games\Http\Requests\UpdateGameLogRequest;
use App\Domains\Games\Models\Game;
use App\Domains\Games\Models\GameLog;
use App\Domains\Games\Services\GameLogService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GameAPIController extends Controller
{
    protected $gameLogService;

    public function __construct(GameLogService $gameLogService)
    {
        $this->gameLogService = $gameLogService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Game $game
     */
    public function store(StoreGameLogRequest $request, Game $game)
    {
        $log = $this->gameLogService->store($game, [
            'nickname' => $request->nickname,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        return response($log)->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param GameLog $log
     * @return GameLog
     */
    public function ranking(GameLog $log)
    {
        return $log->ranking;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param GameLog $log
     */
    public function update(UpdateGameLogRequest $request, GameLog $log)
    {
        $ranking1 = $log->game->logs()->orderBy('score', 'desc')->limit(10)->get();
        $this->gameLogService->update($log, [
            'score' => $request->score,
            'duration' => $request->duration,
        ]);
        $ranking2 = $log->game->logs()->orderBy('score', 'desc')->limit(10)->get();

        $flag = false;
        if ($ranking1->count() < 10) {
            $flag = true;
        }
        if ($ranking1->count() > 10) {
            for ($i = 0; $i < 10; $i++) {
                if ($ranking2[$i] != $ranking1[$i]) {
                    $flag = true;
                }
            }
        }
        if ($flag) {
            event(new Leaderboard($log->game));
        }

        return response('log updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function leaderboard(Game $game)
    {
        return $game->logs()->orderBy('score', 'desc')->limit(10)->get();
    }
}
