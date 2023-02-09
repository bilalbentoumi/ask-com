<?php

namespace App\Http\Controllers\Admin;

use App\Models\Answer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnswersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function edit($id)
    {
        $answer = Answer::findOrFail($id);
        return view('admin.answers.edit', compact('answer'));
    }

    public function update(Request $request, $id)
    {

        $answer = Answer::findOrFail($id);
        $answer->content = $request->answer_content;
        $answer->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        $answer = Answer::findOrFail($id);
        $answer->delete();
        return redirect()->back();
    }
}
