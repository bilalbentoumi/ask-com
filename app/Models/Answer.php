<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Answer extends Model
{

    protected $fillable = [
        'user_id', 'question_id', 'content'
    ];

    public function question()
    {
        return $this->belongsTo('App\Models\Question');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

    public function votes()
    {
        return $this->hasMany('App\Models\Vote');
    }

    public function reports()
    {
        return $this->hasMany('App\Models\Report');
    }

    public function getVotesSumAttribute()
    {
        $sum = 0;
        foreach ($this->votes as $vote) {
            $sum += ($vote->type == 'up' ? 1 : -1);
        }
        return $sum;
    }

    public function voteType()
    {
        $vote = Vote::where('user_id', Auth::user()->id)
            ->where('answer_id', $this->id)
            ->get()->shift();
        if ($vote != null) {
            return $vote->type;
        } else {
            return null;
        }
    }
}
