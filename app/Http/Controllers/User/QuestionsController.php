<?php

namespace App\Http\Controllers\User;

use App\Models\Answer;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Tag;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionsController extends Controller
{

    public function index()
    {
        $questions = Question::paginate(3);

        return view('user.questions.index', compact('questions'));
    }

    public function byTag($name)
    {
        $tag = Tag::where('name', '=', $name)->firstOrFail();
        $questions = Question::whereHas('tags', function ($query) use ($name) {
            $query->where('name', $name);
        })->paginate(3);

        return view('user.questions.index', compact('tag', 'questions'));
    }

    public function create()
    {
        if (!Auth::user()) {
            return redirect('/');
        }

        $categories = Category::all();
        $tags = Tag::all()->unique('name');

        return view('user.questions.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {

        $rules = [
            'title' => 'required|min:20',
            'category' => 'required',
            'question_content' => 'required|min:30',
        ];

        $attributes = [
            'title' => __('lang.title'),
            'category' => __('lang.category'),
            'question_content' => __('lang.content')
        ];

        $this->validate($request, $rules, [], $attributes);

        $question = new Question();
        $question->user_id = Auth::user()->id;
        $question->category_id = $request->category;

        $question->title = $request->title;
        $question->content = $request->question_content;
        $question->save();

        $tags = explode(',', $request->tags);
        if (sizeof($tags) > 0) {
            foreach ($tags as $tag) {
                $t = new Tag();
                $t->question_id = $question->id;
                $t->name = $tag;
                $t->save();
            }
        }

        return redirect($question->url)->with('success', __('lang.success'));
    }

    public function edit($id)
    {
        $question = Question::findOrFail($id);

        if (!Auth::guard('admin')->check()) {
            if (Auth::user() && $question->user->id != Auth::user()->id) {
                return redirect('/');
            } elseif (!Auth::user()) {
                return redirect('/');
            }
        }

        $categories = Category::all();
        $tags = Tag::all()->unique('name');

        return view('user.questions.edit', compact('categories', 'tags', 'question'));
    }

    public function update(Request $request, $id)
    {

        $rules = [
            'title' => 'required|min:20',
            'category' => 'required',
            'question_content' => 'required|min:30',
        ];

        $attributes = [
            'title' => __('lang.title'),
            'category' => __('lang.category'),
            'question_content' => __('lang.content')
        ];

        $this->validate($request, $rules, [], $attributes);

        $question = Question::findOrFail($id);
        $question->category_id = $request->category;
        $question->title = $request->title;
        $question->content = $request->question_content;
        $question->save();

        $original = $question->tags->pluck('name')->toArray();
        $tags = explode(',', $request->tags);
        $to_remove = array_diff($original, $tags);
        $to_add = array_diff($tags, $original);

        foreach ($to_remove as $tag) {
            Tag::where('name', $tag)->where('question_id', $question->id)->delete();
        }

        if (!empty($to_add)) {
            foreach ($to_add as $tag) {
                $t = new Tag();
                $t->question_id = $question->id;
                $t->name = $tag;
                $t->save();
            }
        }

        return redirect($question->url)->with('success', __('lang.success'));
    }

    public function getAnswers($question_id)
    {
        $question = Question::findOrFail($question_id);
        $answers = Answer::orderBy('best', 'DESC')->where('question_id', '=', $question_id)->get();

        if ($question->hasBestAnswer()) {
            $best = $answers->splice(0, 1);
            $answers = $answers->sortByDesc('VotesSum');
            $answers = collect($best)->merge($answers);
        } else {
            $answers = $answers->sortByDesc('VotesSum');
        }

        return $answers;
    }

    public function show($id)
    {
        $question = Question::findOrFail($id);
        $question->views++;
        $question->save();
        $answers = $this->getAnswers($question->id);


        $related = Question::whereHas('tags', function ($query) use ($question) {
            $query->where('name', $question->tags[0]->name);
            for ($i = 1; $i < $question->tags->count(); $i++) {
                $query = $query->orWhere('name', $question->tags[$i]->name);
            }
        })->limit(5)->get();

        foreach ($related as $key => $q) {
            if ($q->id == $question->id) {
                $related->forget($key);
            }
        }

        return view('user.questions.show', compact('question', 'answers', 'related'));
    }

    public function addAnswer(Request $request)
    {

        $question = new Answer();
        $question->user_id = Auth::user()->id;
        $question->question_id = $request->question_id;
        $question->content = $request->answer_content;
        $question->save();

        return redirect()->route('questions.index');
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return redirect()->route('home')->with('success', __('lang.success'));
    }
}
