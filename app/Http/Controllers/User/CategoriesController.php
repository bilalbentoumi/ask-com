<?php

namespace App\Http\Controllers\User;

use App\Models\Answer;
use App\Models\Category;
use App\Helpers\Settings;
use App\Http\Controllers\Controller;
use App\Notification;
use App\Models\Question;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        
        return view('user.categories.index', compact('categories'));
    }

    public function questions($slug)
    {
        $category = Category::where('slug', $slug)->get()->shift();
        $last = Question::where('category_id', $category->id)->paginate(Settings::get('perpage'))->lastPage();
        $route = 'questions.category.data';

        return view('user.categories.questions', compact('category', 'last', 'route'));
    }

    public function questionsData(Request $request)
    {
        $category = Category::where('slug', $request->slug)->get()->shift();
        $questions = Question::where('category_id', $category->id)->paginate(Settings::get('perpage'));

        return view('user.questionslist', compact('questions'));
    }
}
