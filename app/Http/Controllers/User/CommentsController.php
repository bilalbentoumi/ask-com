<?php

namespace App\Http\Controllers\User;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {

        $rules = [
            'comment_content' => 'required',
        ];

        $attributes = [
            'comment_content' => __('lang.content')
        ];

        $this->validate($request, $rules, [], $attributes);

        $comment = new Comment();
        $comment->user_id = Auth::user()->id;
        $comment->answer_id = $request->answer_id;
        $comment->content = $request->comment_content;

        if ($comment->save() && $comment->user->id != $comment->answer->user->id) {
            $notification = new Notification();
            $notification->user_id = $comment->answer->user->id;
            $notification->nuser_id = $comment->user_id;
            $notification->type = 'comment';
            $notification->question_id = $comment->answer->question->id;
            $notification->save();
        }

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {

        $rules = [
            'comment_content' => 'required',
        ];

        $attributes = [
            'comment_content' => __('lang.content')
        ];

        $this->validate($request, $rules, [], $attributes);

        $comment = Comment::findOrFail($id);
        $comment->content = $request->comment_content;
        $comment->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->back();
    }
}
