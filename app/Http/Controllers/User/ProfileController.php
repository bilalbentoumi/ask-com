<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function index($user_id)
    {
        $user = User::where('id', '=', $user_id)->get()->shift();

        return view('user.profile.index', compact('user'));
    }

    public function uploadPicture(Request $request)
    {

        $file = $request->file('picture');

        $dir = 'public/uploads/profile/pictures/';
        $filename = 'user' . Auth::user()->id;
        $file->move($dir, $filename);

        $user = Auth::user();
        $user->picture = '/' . $dir . $filename;
        $user->save();

        return '/' . $dir . $filename;
    }

    public function uploadCover(Request $request)
    {

        $file = $request->file('cover');

        $dir = 'public/uploads/profile/covers/';
        $filename = 'user' . Auth::user()->id;
        $file->move($dir, $filename);

        $user = Auth::user();
        $user->cover = '/' . $dir . $filename;
        $user->save();

        return '/' . $dir . $filename;
    }
}
