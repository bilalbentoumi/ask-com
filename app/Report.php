<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model {

    protected $fillable = [
        'user_id', 'question_id', 'answer_id', 'comment_id'
    ];

    public function user() {
        return $this->belongsTo('App\User');
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

    public function getTypeAttribute() {
        if ($this->question_id != null)
            return 'question';
        else if ($this->answer_id != null)
            return 'answer';
        else if ($this->comment_id != null)
            return 'comment';
        else return null;
    }

    public static function reports() {
        $questionsReports = Report::where('answer_id', '!=', null)->get()->unique('answer_id');
        $answersReports = Report::where('question_id', '!=', null)->get()->unique('question_id');
        $commentsReports = Report::where('comment_id', '!=', null)->get()->unique('comment_id');
        $reports = $questionsReports->merge($answersReports)->merge($commentsReports);
        return $reports;
    }


}
