<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Interest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WizardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function step1()
    {
        return view('user.wizard.step1');
    }

    public function step1_store(Request $request)
    {

        $rules = [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
        ];

        $attributes = [
            'first_name' => __('lang.first_name'),
            'last_name' => __('lang.last_name'),
        ];

        $this->validate($request, $rules, [], $attributes);

        $user = Auth::user();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->save();

        return redirect()->route('wizard.step2');
    }

    public function step2()
    {
        return view('user.wizard.step2');
    }

    public function step2_store(Request $request)
    {

        $rules = [
            'picture' => 'required|image',
        ];

        $attributes = [
            'picture' => __('lang.picture'),
        ];

        $this->validate($request, $rules, [], $attributes);

        $file = $request->file('picture');

        $dir = 'uploads/profile/pictures/';
        $filename = 'user' . Auth::user()->id;
        $file->move($dir, $filename);

        $user = Auth::user();
        $user->picture = '/' . $dir . $filename;
        $user->save();
    }

    public function step3()
    {
        $tags = Tag::all();

        return view('user.wizard.step3', compact('tags'));
    }

    public function step3_store(Request $request)
    {

        $rules = [
            'bio' => 'required|min:3',
            'interests' => 'required|min:3',
        ];

        $attributes = [
            'bio' => __('lang.biography'),
            'interests' => __('lang.interests'),
        ];

        $this->validate($request, $rules, [], $attributes);

        $user = Auth::user();
        $user->bio = $request->bio;
        $user->save();

        $interests = explode(',', $request->interests);
        if (!empty($interests)) {
            foreach ($interests as $interest) {
                $i = new Interest();
                $i->user_id = $user->id;
                $i->name = $interest;
                $i->save();
            }
        }

        return redirect('/');
    }
}
