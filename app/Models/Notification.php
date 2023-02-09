<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    protected $fillable = [
        'user_id', 'content', 'read'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function nuser()
    {
        return $this->belongsTo('App\Models\User', 'nuser_id', 'id');
    }

    public function question()
    {
        return $this->belongsTo('App\Models\Question');
    }

    public function answer()
    {
        return $this->belongsTo('App\Models\Answer');
    }

    public function comment()
    {
        return $this->belongsTo('App\Comment');
    }
}
