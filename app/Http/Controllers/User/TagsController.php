<?php

namespace App\Http\Controllers\User;

use App\Helpers\Settings;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller {

    public function index() {
        $tags = Tag::all()->unique('name');

        return view('user.tags.index', compact('tags'));
    }

    public function questions($name) {

        $tag = Tag::where('name', $name)->get()->shift();
        $last = Question::whereHas('tags', function($query) use ($name) {
            $query->where('name', $name);
        })->paginate(Settings::get('perpage'))->lastPage();

        $route = 'questions.tag.data';

        return view('user.tags.questions', compact('tag', 'last', 'route'));
    }

    public function questionsData(Request $request) {

        $tag = Tag::where('name', $request->name)->get()->shift();

        $questions = Question::whereHas('tags', function($query) use ($request) {
            $query->where('name', $request->name);
        })->paginate(Settings::get('perpage'));

        return view('user.questionslist', compact('questions'));
    }

}
