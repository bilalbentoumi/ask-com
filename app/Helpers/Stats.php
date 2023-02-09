<?php

namespace App\Helpers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Carbon\Carbon;

class Stats
{

    public static function total_questions()
    {
        return Question::all()->count();
    }

    public static function new_questions($date)
    {
        if ($date == 'today') {
            return Question::whereDate('created_at', Carbon::today())->get()->count();
        } elseif ($date == 'week') {
            return Question::whereDate('created_at', '>', Carbon::today()->subWeek())->get()->count();
        } elseif ($date == 'month') {
            return Question::whereDate('created_at', '>', Carbon::today()->subMonth())->get()->count();
        }
    }

    public static function solved_questions()
    {
        $count = 0;
        foreach (Question::all() as $question) {
            if ($question->hasBestAnswer()) {
                $count++;
            }
        }
        return $count;
    }

    public static function solved_questions_percent()
    {
        return sprintf('%0.2f', Stats::solved_questions() ?
            Stats::solved_questions() * 100 / Stats::total_questions() :
            0);
    }

    public static function unsolved_questions()
    {
        return Stats::total_questions() - Stats::solved_questions();
    }

    public static function unsolved_questions_percent()
    {
        return sprintf('%0.2f', Stats::unsolved_questions() ?
            Stats::unsolved_questions() * 100 / Stats::total_questions() :
            0);
    }

    public static function hot_questions()
    {
        return Question::orderBy('views', 'DESC')->limit(5)->get();
    }

    public static function total_users()
    {
        return User::all()->count();
    }

    public static function active_users()
    {
        return User::where('status', 1)->get()->count();
    }

    public static function active_users_percent()
    {
        return sprintf('%0.2f', Stats::active_users() * 100 / self::total_users());
    }

    public static function inactive_users()
    {
        return User::where('status', 0)->get()->count();
    }

    public static function inactive_users_percent()
    {
        return sprintf('%0.2f', Stats::inactive_users() * 100 / self::total_users());
    }

    public static function new_users($date)
    {
        if ($date == 'today') {
            return User::whereDate('created_at', Carbon::today())->get()->count();
        } elseif ($date == 'week') {
            return User::whereDate('created_at', '>', Carbon::today()->subWeek())->get()->count();
        } elseif ($date == 'month') {
            return User::whereDate('created_at', '>', Carbon::today()->subMonth())->get()->count();
        }
    }

    public static function total_answers()
    {
        return Answer::all()->count();
    }
}
