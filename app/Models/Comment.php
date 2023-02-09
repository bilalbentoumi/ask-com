<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = [
        'user_id', 'answer_id', 'content'
    ];

    public function answer()
    {
        return $this->belongsTo('App\Models\Answer');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function reports()
    {
        return $this->hasMany('App\Models\Report');
    }

    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }
}
