<?php

namespace App\Domains\Games\Http\Controllers;

use App\Domains\Games\Models\Game;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GameAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Game $game
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function store(Request $request, Game $game)
    {
        $request->validate([
            'nickname' => 'required|string|max:255',
            'score' => 'required|integer',
        ]);
        $game->logs()->create([
            'nickname' => $request->nickname,
            'score' => $request->score,
            'duration' => 100,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        return response()->json(['message' => 'done'])->setStatusCode(200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($game)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
