<?php

namespace App\Http\Controllers\User;

use App\Helpers\Settings;
use App\Http\Controllers\Controller;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {

    public function __construct() {
        //$this->middleware('auth');
    }

    public function index() {
        return view('user.home');
    }

    public function splash() {
        return view('user.splash');
    }

    public function newest() {
        $last = Question::orderBy('created_at', 'DESC')->paginate(Settings::get('perpage'))->lastPage();
        $route = 'questions.newest.data';
        return view('user.questions', compact('last', 'route'));
    }

    public function newestData(Request $request) {
        $questions = Question::orderBy('created_at', 'DESC')->paginate(Settings::get('perpage'));
        return view('user.questionslist', compact('questions'));
    }

    public function interested() {
        $interests = Auth::user()->interests;
        $questions = Question::whereHas('tags', function($query) use($interests) {
            $query->where('name', $interests[0]->name);
            for ($i = 1; $i < $interests->count(); $i++) {
                $query = $query->orWhere('name', $interests[$i]->name);
            }
        })->paginate(Settings::get('perpage'));
        $last = $questions->lastPage();
        $route = 'questions.interested.data';
        return view('user.questions', compact('last', 'route'));
    }

    public function interestedData(Request $request) {
        $interests = Auth::user()->interests;
        $questions = Question::whereHas('tags', function($query) use($interests) {
            $query->where('name', $interests[0]->name);
            for ($i = 1; $i < $interests->count(); $i++) {
                $query = $query->orWhere('name', $interests[$i]->name);
            }
        })->paginate(Settings::get('perpage'));
        return view('user.questionslist', compact('questions'));
    }

    public function search(Request $request) {
        $questions = Question::where('title', 'like', '%' . $request->keyword . '%')->limit(5)->get();
        return view('user.search', compact('questions'));
    }

}
