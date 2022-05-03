<?php

use App\Domains\Games\Http\Controllers\GameAPIController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/games/{game}', [GameAPIController::class, 'store']);
Route::post('/gameLogs/{log}', [GameAPIController::class, 'update']);
