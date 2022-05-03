<?php

namespace App\Domains\Games\Http\Controllers;

use App\Domains\Games\Http\Requests\StoreGameLogRequest;
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
     * @param  int  $id
     * @return Response
     */
    public function show($game)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
    public function update(Request $request, GameLog $log)
    {
        $this->gameLogService->update($log, [
            'score' => $request->score,
            'duration' => $request->duration,
        ]);
        return response('log updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
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
