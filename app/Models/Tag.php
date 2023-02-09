<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    protected $fillable = [
        'question_id', 'name'
    ];

    public function question()
    {
        return $this->belongsTo('App\Models\Question');
    }

    public function questions()
    {
        $questions = Question::whereHas('tags', function ($query) {
            $query->where('name', $this->name);
        })->get();

        return $questions;
    }
}
