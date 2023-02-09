<?php

namespace App\Http\Controllers\User;

use App\Models\Answer;
use App\Helpers\Settings;
use App\Http\Controllers\Controller;
use App\Notification;
use App\Models\Point;
use App\Models\Question;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['loadVotes', 'voteExists']);
    }

    public function store(Request $request)
    {

        $question = Question::find($request->question_id);

        $answer = new Answer();
        $answer->user_id = Auth::user()->id;
        $answer->question_id = $request->question_id;
        $answer->content = $request->answer_content;

        if ($answer->save() && $answer->user->id != $question->user->id) {
            $notification = new Notification();
            $notification->user_id = $answer->question->user->id;
            $notification->nuser_id = $answer->user_id;
            $notification->type = 'answer';
            $notification->question_id = $answer->question->id;
            $notification->save();
        }

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {

        $answer = Answer::findOrFail($id);
        $answer->content = $request->answer_content;
        $answer->save();

        return redirect()->back();
    }


    public function best(Request $request)
    {
        $question = Question::find($request->question_id);
        $answer = Answer::find($request->answer_id);
        $answer->best = !$answer->best;
        $answer->save();

        $point = new Point();
        $point->user_id = $answer->user->id;
        $point->value = $answer->best ? Settings::get('best_answer_points') : -Settings::get('best_answer_points');
        $point->save();

        foreach ($question->answers as $answer) {
            if ($answer->id != $request->answer_id && $answer->best) {

                $answer->best = false;
                $answer->save();

                $point = new Point();
                $point->user_id = $answer->user->id;
                $point->value =  -Settings::get('best_answer_points');
                $point->save();
            }
        }

        if ($answer->save() && $answer->best && $answer->user->id != $question->user->id) {
            $notification = new Notification();
            $notification->user_id = $answer->user_id;
            $notification->nuser_id = $question->user_id;
            $notification->type = 'best';
            $notification->question_id = $question->id;
            $notification->save();
        }

        return redirect()->back();
    }

    public function makeVote(Request $request)
    {
        if (Auth::user()) {

            $count = null;

            if ($request->answer_id != null && $request->question_id == null) {
                $user_id = Answer::find($request->answer_id)->user->id;
                if (Auth::user()->id != $user_id) {
                    Vote::makeVote(Auth::user()->id, 'answer', $request->answer_id, $request->type);
                    $count = Answer::find($request->answer_id)->votesSum;
                }
            } elseif ($request->question_id != null && $request->answer_id == null) {
                $user_id = Question::find($request->question_id)->user->id;
                if (Auth::user()->id != $user_id) {
                    Vote::makeVote(Auth::user()->id, 'question', $request->question_id, $request->type);
                    $count = Question::find($request->question_id)->votesSum;
                }
            }

            return $count;
        }
    }

    public function destroy($id)
    {
        $answer = Answer::findOrFail($id);
        $answer->delete();

        return redirect()->back();
    }
}
