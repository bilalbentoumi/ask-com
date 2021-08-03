<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model {

    protected $fillable = [
        'user_id', 'content', 'read'
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function nuser() {
        return $this->belongsTo('App\User', 'nuser_id', 'id');
    }

    public function question() {
        return $this->belongsTo('App\Question');
    }

    public function answer() {
        return $this->belongsTo('App\Answer');
    }

    public function comment() {
        return $this->belongsTo('App\Comment');
    }

}
