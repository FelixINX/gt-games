<?php

namespace App\Http\Controllers\API\Scatt;

use App\Events\Scatt\ChangeState;
use App\Events\Scatt\ConfirmAnswers;
use App\Events\Scatt\RoundApproval;
use App\Events\Scatt\SendAnswers;
use App\Http\Controllers\Controller;
use App\Model\Scatt\Answer;
use App\Model\Scatt\Game;
use App\Model\Scatt\Round;
use App\Model\User;
use Illuminate\Http\Request;

class RoundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Scatt\Round  $round
     * @return \Illuminate\Http\Response
     */
    public function show(Round $round)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Scatt\Round  $round
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Round $round)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Scatt\Round  $round
     * @return \Illuminate\Http\Response
     */
    public function destroy(Round $round)
    {
        //
    }

    /**
     * Confirm answers of this round
     *
     */
    public function confirm(Request $request, Round $round)
    {
        // Set user
        $user = User::where('api_token', $request->input('api_token'))->firstOrFail();

        // Set approval
        $approval = $round->user_approval;
        $approval[$user->id] = $request->input('confirmed');
        $round->user_approval = $approval;
        $round->save();

        // Broadcast
        broadcast(new RoundApproval($round));

        return response()->json(['message' => 'OK'], 200);
    }

    /**
     * Stop the game
     *
     * @param Request $request
     * @param Round $round
     * @return \Illuminate\Http\JsonResponse
     */
    public function stop(Request $request, Round $round)
    {
        // Set user
        $user = User::where('api_token', $request->input('api_token'))->firstOrFail();

        // Set user approval
        $approval = [];
        foreach ($round->game->users as $gameUser) {
            $approval[$gameUser->id] = false;
        }
        $round->user_approval = $approval;

        // Set round as done
        $round->done = true;
        $round->save();
        $round->game->state = 'answers';
        $round->game->save();

        // Broadcast
        broadcast(new SendAnswers($round));
        broadcast(new ChangeState($round->game, $user, 'answers', 5, $round));
        broadcast(new RoundApproval($round));

        return response()->json(['message' => 'OK'], 200);
    }

    /**
     * Continue the round (submit final answers)
     *
     * @param Request $request
     * @param Round $round
     * @return \Illuminate\Http\JsonResponse
     */
    public function continue(Request $request, Round $round)
    {
        // Set user
        $user = User::where('api_token', $request->input('api_token'))->firstOrFail();

        // Set results
        $availablePoints = 5 * count($round->answers);
        $goodAnswers = $round->answers->where('approved', true);
        if (count($goodAnswers)) {
            $individualPoints = ceil($availablePoints / count($goodAnswers));
        }
        $usersReputation = $round->game->users_reputation;
        foreach ($goodAnswers as $answer) {
            $answer->user->reputation += $individualPoints;
            $answer->user->save();
            $usersReputation[$answer->user->id] += $individualPoints;
        }
        $round->game->users_reputation = $usersReputation;
        $round->game->save();

        // Find the next round
        $newRound = Round::where([
            'game_id' => $round->game->id,
            'done' => false
        ])->first();

        // Broadcast next state
        if ($newRound) {
            $round->game->state = 'round';
            $round->game->active_round_id = $newRound->id;
            broadcast(new ChangeState($round->game, $user, 'round', 3, $newRound));
        } else {
            $round->game->state = 'results';
            broadcast(new ChangeState($round->game, $user, 'results', 5, $round));
        }
        $round->game->save();

        return response()->json(['message' => 'OK'], 200);
    }
}
