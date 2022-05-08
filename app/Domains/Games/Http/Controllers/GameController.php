<?php

namespace App\Domains\Games\Http\Controllers;

use App\Domains\Games\Models\Game;
use App\Domains\Games\Models\GameLog;
use App\Domains\Games\Services\GameService;
use App\Http\Controllers\Controller;

class GameController extends Controller
{
    protected $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function index()
    {
        return view('backend.games.index');
    }

    public function index2list()
    {
        $games = $this->gameService->query();
        return datatables()->of($games)
            ->editColumn('title', function ($game) {
                return $game->link;
            })
            ->addColumn('action', function ($game) {
                return '<a href="'. route('frontend.games.run', $game->id). '" class="btn btn-primary"><i class="fas fa-eye"></i></a>';
            })
            ->editColumn('created_at', function ($game) {
                return verta($game->created_at)->timezone(config('app.timezone'))->format('H:i y/m/d');
            })
            ->rawColumns(['title', 'action'])
            ->make(true);
    }

    public function run(Game $game)
    {
        if ($game->id == 1)
            return view('backend.games.snake');
    }

    public function show(Game $game)
    {
        return view('backend.games.show', compact('game'));
    }

    public function leaderboard(Game $game)
    {
        $logs = $game->logs();
        return datatables()->of($logs)
            ->editColumn('created_at', function ($game) {
                return verta($game->created_at)->timezone(config('app.timezone'))->format('H:i y/m/d');
            })
            ->addColumn('details', function ($log) {
                $btn = '<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#game-log-detail-'. $log->id .'"><i class="fas fa-eye"></i></button>';
                $modal = '<div class="modal fade" id="game-log-detail-'. $log->id .'" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="game-log-detail-'. $log->id .'-label" aria-hidden="true">
                            <div class="modal-dialog ">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="game-log-detail-'. $log->id .'-label">'. __('ID') . ' '. $log->id .'</h5>
                                    </div>
                                    <div class="modal-body text-left">
                                        <b>User Agent: </b><span class="text-wrap">'. $log->user_agent .'</span><br>
                                        <b>IP: </b><span class="text-wrap">'. $log->ip .'</span>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>';
                return $btn . $modal;
            })
            ->rawColumns(['details'])
            ->make(true);
    }
}
