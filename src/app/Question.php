<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Question extends Model {

    protected $fillable = [
        'user_id', 'category_id', 'title', 'content'
    ];

    public function category() {
        return $this->belongsTo('App\Category');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function answers() {
        return $this->hasMany('App\Answer');
    }

    public function notifications() {
        return $this->hasMany('App\Notification');
    }

    public function votes() {
        return $this->hasMany('App\Vote');
    }

    public function tags() {
        return $this->hasMany('App\Tag');
    }

    public function reports() {
        return $this->hasMany('App\Report');
    }

    public  function tags_string() {
        $i = count($this->tags);
        $tags_string = '';
        foreach ($this->tags as $tag) {
            $tags_string .= $tag->name;
            if ($last_iteration = (--$i))
                $tags_string .= ', ';
        }
        return $tags_string;
    }

    public function getVotesSumAttribute() {
        $sum = 0;
        foreach($this->votes as $vote) {
            $sum += ($vote->type == 'up' ? 1 : -1);
        }
        return $sum;
    }

    public function hasBestAnswer() {
        foreach ($this->answers as $answer) {
            if ($answer->best)
                return true;
        }
        return false;
    }

    public function hasTags() {
        return sizeof($this->tags) > 0;
    }

    public function getUrlAttribute() {
        return route('question.show', [$this->id, str_replace(' ', '-', $this->title)]);
    }

    public function getSummaryAttribute() {
        return mb_substr(strip_tags($this->content), 0, 80) . ' ...';
    }

    public function voteType() {
        $vote = Vote::where('user_id', Auth::user()->id)
            ->where('question_id', $this->id)
            ->get()->shift();
        if ($vote != null)
            return $vote->type;
        else
            return null;
    }

}
