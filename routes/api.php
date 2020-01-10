<?php

use App\Http\Resources\Scatt\AnswerResource;
use App\Http\Resources\UserForLeaderboardResource;
use App\Model\Scatt\Answer;
use App\Model\Scatt\Round;
use App\Model\User;
use Illuminate\Http\Request;
use App\Model\Scatt\Game as ScattGame;
use App\Http\Resources\Scatt\GameHomeResource;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Leaderboard
Route::middleware('auth:api')->get('/leaderboard', function (Request $request) {
    return UserForLeaderboardResource::collection(User::all());
});

// Scatt apiResource controller
Route::apiResource('/scatt/categories', 'API\Scatt\CategoryController')->middleware('auth:api');
Route::apiResource('/scatt/games', 'API\Scatt\GameController')->middleware('auth:api');

// Scatt resources
Route::middleware('auth:api')->get('/scatt/available', function (Request $request) {
    return GameHomeResource::collection(ScattGame::where(['active' => true, 'started' => false, 'state' => 'lobby'])->get());
});
Route::middleware('auth:api')->get('/scatt/rounds/{round}/answers', function (Request $request, Round $round) {
    return AnswerResource::collection(Answer::where('round_id', $round->id)->get());
});

// Scatt controller custom route
Route::middleware('auth:api')->group(function () {
   Route::post('/scatt/games/{game}/join', 'API\Scatt\GameController@join');
   Route::post('/scatt/games/{game}/leave', 'API\Scatt\GameController@leave');
   Route::post('/scatt/games/{game}/start', 'API\Scatt\GameController@start');
   Route::get('/scatt/games/{game}/results', 'API\Scatt\GameController@results');
   Route::post('/scatt/rounds/{round}/confirm', 'API\Scatt\RoundController@confirm');
   Route::post('/scatt/rounds/{round}/stop', 'API\Scatt\RoundController@stop');
   Route::post('/scatt/rounds/{round}/continue', 'API\Scatt\RoundController@continue');
   Route::post('/scatt/answers/massStore', 'API\Scatt\AnswerController@massStore');
   Route::post('/scatt/answers/{answer}/accept', 'API\Scatt\AnswerController@accept');
});