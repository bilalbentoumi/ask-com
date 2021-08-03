<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    protected $fillable = [
        'user_id', 'answer_id', 'content'
    ];

    public function answer() {
        return $this->belongsTo('App\Answer');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function reports() {
        return $this->hasMany('App\Report');
    }

    public function notifications() {
        return $this->hasMany('App\Notification');
    }

}
