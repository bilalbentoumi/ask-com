<?php

namespace App\Helpers;

use App\Models\Category;
use App\Models\Notification;
use App\Models\Question;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Helper
{

    public static function categories()
    {
        return Category::all();
    }

    public static function latest_users()
    {
        return User::orderBy('created_at', 'DESC')->limit(5)->get();
    }

    public static function latest_questions()
    {
        return Question::orderBy('created_at', 'DESC')->limit(5)->get();
    }

    public static function tags()
    {
        return Tag::all()->unique('name')->slice(0, 5);
    }

    public static function notifications()
    {
        $notifications = Notification::where('user_id', '=', Auth::user()->id)->orderBy('id', 'DESC')->limit(5)->get();
        foreach ($notifications as $notification) {
            $question = Question::findOrFail($notification->question_id);
            $notification->title = mb_substr($question->title, 0, 30) . ' ...';
            $notification->url = $question->url;
        }
        return $notifications;
    }

    public static function notifications_count()
    {
        return Notification::where('user_id', '=', Auth::user()->id)
            ->where('read', '=', 0)
            ->get()->count();
    }

    public static function interestedQuestions()
    {
        $interests = Auth::user()->interests;
        $questions = new Collection();
        if (sizeof($interests) > 0) {
            $questions = Question::whereHas('tags', function ($query) use ($interests) {
                $query->where('name', $interests[0]->name);
                for ($i = 1; $i < $interests->count(); $i++) {
                    $query = $query->orWhere('name', $interests[$i]->name);
                }
            })->get();
        }
        return $questions;
    }
}
