<?php

namespace App\Domains\Games\Http\Controllers;

use App\Http\Controllers\Controller;

class GameController extends Controller
{
    public function index()
    {
        return view('backend.games.index');
    }

    public function run($game)
    {
        if ($game == 'snake')
            return view('backend.games.snake');
        else
            return redirect()->back()->withFlashDanger('Game not found');
    }
}
