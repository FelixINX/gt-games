<?php

namespace App\Http\Controllers\API\Scatt;

use App\Http\Resources\Scatt\ResultResource;
use App\Model\User;
use App\Model\Scatt\Game;
use App\Model\Scatt\Round;
use Illuminate\Http\Request;
use App\Events\Scatt\PlayerList;
use App\Events\Scatt\ChangeState;
use App\Http\Controllers\Controller;
use App\Http\Resources\Scatt\GameResource;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return GameResource::collection(Game::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Set user
        $user = User::where('api_token', $request->input('api_token'))->firstOrFail();

        // Create the game
        $game = new Game([
            'timer' => $request->input('timer'),
            'number_of_rounds' => $request->input('numberOfRounds'),
            'user_id' => $user->id
        ]);
        $game->save();

        // Attach user to the game
        $game->users()->attach($user->id);

        // Attach categories to the game
        foreach ($request->input('categories') as $category) {
            $game->categories()->attach($category);
        }

        // Create rounds
        $letters = range('A', 'Z');
        foreach (range(1, $game->number_of_rounds) as $roundNumber) {
            $randomNumber = array_rand($letters);
            $round = new Round([
                'number' => $roundNumber,
                'letter' => $letters[$randomNumber],
                'game_id' => $game->id
            ]);
            $round->save();
            unset($letters[$randomNumber]);
        }

        return response()->json($game, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Scatt\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        return GameResource::make($game);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        //
    }

    /**
     * Join the game
     *
     * @param Request $request
     * @param Game $game
     * @return \Illuminate\Http\JsonResponse
     */
    public function join(Request $request, Game $game)
    {
        // Set user
        $user = User::where('api_token', $request->input('api_token'))->firstOrFail();

        // Attach user to game
        $game->users()->syncWithoutDetaching($user);

        // Broadcast
        event(new PlayerList($game));

        return response()->json(['message' => 'OK'], 200);
    }

    /**
     * Leave the game
     *
     * @param Request $request
     * @param Game $game
     * @return \Illuminate\Http\JsonResponse
     */
    public function leave(Request $request, Game $game)
    {
        // Set user
        $user = User::where('api_token', $request->input('api_token'))->firstOrFail();

        // Check if request user is user
        if ($request->input('userId') === $user->id) {
            $game->users()->detach($user);

            // Broadcast
            event(new PlayerList($game));

            return response()->json(['message' => 'OK'], 200);
        } elseif ($user->id === $game->user_id) {
            // ^ Check if user is mod
            $game->users()->detach($request->input('userId'));

            // Broadcast
            event(new PlayerList($game));

            return response()->json(['message' => 'OK'], 200);
        } else {
            return response()->json(['message' => 'Not mod'], 401);
        }


        // Return the new playerList
        return response()->json($game);
    }

    /**
     * Start the game
     *
     * @param Request $request
     * @param Game $game
     * @return \Illuminate\Http\JsonResponse
     */
    public function start(Request $request, Game $game)
    {
        // Set user
        $user = User::where('api_token', $request->input('api_token'))->firstOrFail();

        // Check if user is mod
        if ($user->id == $game->user_id) {
            // Find the first round
            $round = Round::where([
                'game_id' => $game->id,
                'done' => false
            ])->first();

            // Setup users reputation
            $usersReputation = $game->users_reputation;
            foreach ($game->users as $gameUser) {
                $usersReputation[$gameUser->id] = 0;
            }
            $game->users_reputation = $usersReputation;

            // Set the game as started
            $game->started = true;
            $game->state = 'round';
            $game->active_round_id = $round->id;
            $game->save();

            broadcast(new ChangeState($game, $user, 'round', 3, $round));

            return response()->json(['message' => 'OK'], 200);
        } else {
            return response()->json(['message' => 'Not mod'], 401);
        }
    }

    /**
     * Show the final results
     *
     * @param Request $request
     * @param Game $game
     * @return \Illuminate\Http\JsonResponse
     */
    public function results(Request $request, Game $game)
    {
        return ResultResource::make($game);
    }
}
