<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function questions() {
        return $this->hasMany('App\Question');
    }

    public function answers() {
        return $this->hasMany('App\Answer');
    }

    public function points() {
        return $this->hasMany('App\Point');
    }

    public function interests() {
        return $this->hasMany('App\Interest');
    }

    public function getFullNameAttribute() {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getBestAnswersAttribute() {
        return $this->answers()->where('best', true);
    }

    public function getPicUrlAttribute() {
        return $this->picture ? $this->picture : '/images/noimg.png';
    }

    public function getCoverUrlAttribute() {
        return $this->cover ? $this->cover : '/images/nocover.jpg';
    }

    public function getPointsCountAttribute() {
        $sum = 0;
        foreach($this->points as $point) {
            $sum += $point->value;
        }
        return $sum;
    }

    public function interests_string() {
        $i = count($this->interests);
        $interests_string = '';
        foreach ($this->interests as $interest) {
            $interests_string .= $interest->name;
            if ($last_iteration = (--$i))
                $interests_string .= ', ';
        }
        return $interests_string;
    }

    public function reported($item) {
        if ($item instanceof Question)
            return Report::where('user_id', $this->id)->where('question_id', $item->id)->exists();
        else if ($item instanceof Answer)
            return Report::where('user_id', $this->id)->where('answer_id', $item->id)->exists();
        else if ($item instanceof Comment)
            return Report::where('user_id', $this->id)->where('comment_id', $item->id)->exists();

        return false;
    }

}