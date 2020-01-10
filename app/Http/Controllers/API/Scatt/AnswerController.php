<?php

namespace App\Http\Controllers\API\Scatt;

use App\Events\Scatt\AcceptAnswer;
use App\Events\Scatt\AnswersList;
use App\Events\Scatt\ApprovedAnswersList;
use App\Http\Controllers\Controller;
use App\Model\Scatt\Answer;
use App\Model\Scatt\Round;
use App\Model\User;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Scatt\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Create multiples answers
     *
     * @param Request $request
     * @param Answer $answer
     * @return \Illuminate\Http\JsonResponse
     */
    public function massStore(Request $request, Answer $answer)
    {
        // Set user
        $user = User::where('api_token', $request->input('api_token'))->firstOrFail();

        // Set round
        $round = Round::where('id', $request->input('roundId'))->firstOrFail();

        // Delete existing answers (if any)
        Answer::where(['round_id' => $round->id, 'user_id' => $user->id])->delete();

        // Set user approval
        $approval = [];
        foreach ($round->game->users as $approvalUser) {
            $approval[$approvalUser->id] = true;
        }

        // Create answer
        foreach ($round->game->categories as $category) {
            if (array_key_exists($category->id, $request->input('answers'))) {
                Answer::create([
                    'round_id' => $round->id,
                    'category_id' => $category->id,
                    'user_id' => $user->id,
                    'content' => $request->input('answers')[$category->id],
                    'user_approval' => $approval
                ]);
            } else {
                Answer::create([
                    'round_id' => $round->id,
                    'category_id' => $category->id,
                    'user_id' => $user->id,
                    'content' => '',
                    'user_approval' => $approval
                ]);
            }
        }

        // Broadcast answers
        broadcast(new AnswersList($round));

        return response()->json(['message' => 'OK'], 200);
    }

    /**
     * Accept an answer
     *
     * @param Request $request
     * @param Answer $answer
     * @return \Illuminate\Http\JsonResponse
     */
    public function accept(Request $request, Answer $answer)
    {
        // Set user
        $user = User::where('api_token', $request->input('api_token'))->firstOrFail();

        if ($answer->round->game->hasUser($user->id)) {
            // Set accept
            $approval = $answer->user_approval;
            $approval[$user->id] = $request->input('accept');
            $answer->user_approval = $approval;

            // Set majority approval
            $timesTrue = count(array_filter($approval));
            $timesFalse = sizeof($approval) - $timesTrue;

            if ($timesTrue > $timesFalse) {
                $answer->approved = true;
            } else {
                $answer->approved = false;
            }

            $answer->save();

            // Broadcast
            broadcast(new AnswersList($answer->round));

            return response()->json(['message' => 'OK'], 200);
        } else {
            return response()->json(['message' => 'Not in game!'], 401);
        }
    }
}
