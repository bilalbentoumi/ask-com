<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Interest;
use App\Models\Question;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function general()
    {
        return view('user.settings.general');
    }

    public function update_general(Request $request)
    {

        $user = Auth::user();

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id
        ];

        $attributes = [
            'first_name' => __('lang.first_name'),
            'last_name' => __('lang.last_name'),
            'email' => __('lang.email')
        ];

        $this->validate($request, $rules, [], $attributes);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->save();

        return redirect()->back()->with('success', __('lang.success'));
    }

    public function changepass()
    {
        return view('user.settings.changepass');
    }

    public function update_password(Request $request)
    {

        $user = Auth::user();

        $rules = [
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    return $fail(__('The current password is incorrect.'));
                }
            }],
            'new_password'                        => 'required|min:8',
            'confirm_password'                    => 'same:new_password'
        ];
        $attributes = [
            'current_password'              => __('lang.current_password'),
            'new_password'                  => __('lang.new_password'),
            'confirm_password'              => __('lang.confirm_password')
        ];
        $this->validate($request, $rules, [], $attributes);

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', __('lang.success'));
    }

    public function profile()
    {
        $tags = Tag::all();
        return view('user.settings.profile', compact('tags'));
    }

    public function update_profile(Request $request)
    {

        $user = Auth::user();
        $user->bio = $request->bio;
        $user->facebook = $request->facebook;
        $user->twitter = $request->twitter;
        $user->save();

        $original = $user->interests != null ? $user->interests->pluck('name')->toArray() : [];
        $interests = explode(',', $request->interests);
        $to_remove = array_diff($original, $interests);
        $to_add = array_diff($interests, $original);

        foreach ($to_remove as $interest) {
            Interest::where('name', $interest)->where('user_id', $user->id)->delete();
        }

        if (!empty($to_add)) {
            foreach ($to_add as $interest) {
                $i = new Interest();
                $i->user_id = $user->id;
                $i->name = $interest;
                $i->save();
            }
        }

        return redirect()->back()->with('success', __('lang.success'));
    }

    public function myquestions()
    {
        $questions = Question::where('user_id', Auth::user()->id)->get();
        
        return view('user.settings.questions', compact('questions'));
    }
}
