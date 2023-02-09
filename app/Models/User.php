<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function questions()
    {
        return $this->hasMany('App\Models\Question');
    }

    public function answers()
    {
        return $this->hasMany('App\Models\Answer');
    }

    public function points()
    {
        return $this->hasMany('App\Models\Point');
    }

    public function interests()
    {
        return $this->hasMany('App\Models\Interest');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getBestAnswersAttribute()
    {
        return $this->answers()->where('best', true);
    }

    public function getPicUrlAttribute()
    {
        return $this->picture ? $this->picture : '/images/noimg.png';
    }

    public function getCoverUrlAttribute()
    {
        return $this->cover ? $this->cover : '/images/nocover.jpg';
    }

    public function getPointsCountAttribute()
    {
        $sum = 0;
        foreach ($this->points as $point) {
            $sum += $point->value;
        }
        return $sum;
    }

    public function interests_string()
    {
        $i = count($this->interests);
        $interests_string = '';
        foreach ($this->interests as $interest) {
            $interests_string .= $interest->name;
            if ($last_iteration = (--$i)) {
                $interests_string .= ', ';
            }
        }
        return $interests_string;
    }

    public function reported($item)
    {
        if ($item instanceof Question) {
            return Report::where('user_id', $this->id)->where('question_id', $item->id)->exists();
        } elseif ($item instanceof Answer) {
            return Report::where('user_id', $this->id)->where('answer_id', $item->id)->exists();
        } elseif ($item instanceof Comment) {
            return Report::where('user_id', $this->id)->where('comment_id', $item->id)->exists();
        }

        return false;
    }
}
