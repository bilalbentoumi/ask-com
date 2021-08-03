<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Category;
use App\Http\Controllers\Controller;
use App\Question;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller {

    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index() {
        return view('admin.home');
    }

    public function create() {
        return view('admin.auth.register');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name'          => 'required',
            'email'         => 'required',
            'password'      => 'required'
        ]);

        $admins = new Admin();
        $admins->name = $request->name;
        $admins->email = $request->email;
        $admins->password=bcrypt($request->password);
        $admins->save();
        return redirect()->route('admin.login');
    }

    public function search(Request $request) {
        $admins = Admin::where('first_name', 'like', '%' . $request->keyword . '%')
            ->orWhere('last_name', 'like', '%' . $request->keyword . '%')
            ->orWhere('email', 'like', '%' . $request->keyword . '%')
            ->limit(3)->get();
        $users = User::where('first_name', 'like', '%' . $request->keyword . '%')
            ->orWhere('last_name', 'like', '%' . $request->keyword . '%')
            ->orWhere('email', 'like', '%' . $request->keyword . '%')
            ->limit(3)->get();
        $questions = Question::where('title', 'like', '%' . $request->keyword . '%')->limit(3)->get();
        $categories = Category::where('name', 'like', '%' . $request->keyword . '%')->limit(3)->get();
        return view('admin.search', compact('users', 'admins', 'questions', 'categories'));
    }

}
