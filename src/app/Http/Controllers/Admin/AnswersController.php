<?php

namespace App\Http\Controllers\Admin;

use App\Answer;
use App\Helpers\Settings;
use App\Http\Controllers\Controller;
use App\Notification;
use App\Point;
use App\Question;
use App\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller {

    public function __construct() {
        $this->middleware('auth:admin');
    }


    public function edit($id) {
        $answer = Answer::findOrFail($id);
        return view('admin.answers.edit', compact('answer'));
    }

    public function update(Request $request, $id) {

        $validatedData = $request->validate([
            'answer_content'    => 'required'
        ]);

        $answer = Answer::findOrFail($id);
        $answer->content = $request->answer_content;
        $answer->save();

        return redirect()->back();
    }

    public function destroy($id) {
        $answer = Answer::findOrFail($id);
        $answer->delete();
        return redirect()->back();
    }

}
