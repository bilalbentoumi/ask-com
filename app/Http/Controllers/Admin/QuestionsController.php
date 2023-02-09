<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $questions = Question::all();

        return view('admin.questions.index', compact('questions'));
    }

    public function show($id)
    {
        $question = Question::findOrFail($id);

        return view('admin.questions.show', compact('question'));
    }

    public function edit($id)
    {
        $question = Question::findOrFail($id);
        $categories = Category::all();
        $users = User::all();
        $tags = Tag::all()->unique('name');

        return view('admin.questions.edit', compact('question', 'categories', 'users', 'tags'));
    }

    public function update(Request $request, $id)
    {

        $rules = [
            'title' => 'required',
            'category' => 'required',
            'question_content' => 'required'
        ];

        $attributes = [
            'title' => __('admin.title'),
            'category' => __('admin.category'),
            'question_content' => __('admin.content')
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

        if (!empty($to_add[0])) {
            foreach ($to_add as $tag) {
                $t = new Tag();
                $t->question_id = $question->id;
                $t->name = $tag;
                $t->save();
            }
        }

        return redirect()->route('questions.index')->with('success', __('lang.success'));
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return redirect()->route('questions.index')->with('success', __('lang.success'));
    }
}
