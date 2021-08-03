<?php

namespace App;

use App\Helpers\Settings;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model {

    protected $fillable = [
        'user_id', 'question_id', 'type'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function answer() {
        return $this->belongsTo('App\Answer');
    }

    public function question() {
        return $this->belongsTo('App\Question');
    }

    public static function makeVote($user_id, $context, $context_id, $type) {
        $vote = Vote::where($context . '_id', '=', $context_id)
            ->where('user_id', '=', $user_id)
            ->get()->shift();

        if ($context == 'answer') {
            $puser_id = Answer::find($context_id)->user_id;
        } else if ($context == 'question') {
            $puser_id = Question::find($context_id)->user_id;
        }

        if ($vote != null) {
            if ($vote->type == $type && $type == 'up' || $vote->type == $type && $type == 'down') {
                $point = new Point();
                $point->user_id = $puser_id;
                if ($type == 'up') {
                    $point->value = -Settings::get('down_vote_points');
                } else {
                    $point->value = Settings::get('up_vote_points');
                }
                $point->save();
                return $vote->delete();
            } else {
                $point = new Point();
                $point->user_id = $puser_id;
                if ($type == 'up') {
                    $point->value = 2 * Settings::get('up_vote_points');
                } else {
                    $point->value = 2 * (-Settings::get('down_vote_points'));
                }
                $point->save();

                $vote->type = $type;
                return $vote->save();
            }
        } else {
            $vote = new Vote();
            $vote->user_id = $user_id;
            $vote->{$context . '_id'} = $context_id;
            $vote->type = $type;
            $point = new Point();
            $point->user_id = $puser_id;
            $point->value = $type == 'up' ? Settings::get('up_vote_points') : -Settings::get('down_vote_points');
            $point->save();
            return $vote->save();
        }
    }

}
