<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Settings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {

        $rules = [
            'sitename' => 'required',
            'description' => 'required',
            'default_lang' => 'required',
            'perpage' => 'required|integer',
            'up_vote_points' => 'required|integer',
            'down_vote_points' => 'required|integer',
            'best_answer_points' => 'required|integer',
        ];

        $attributes = [
            'sitename' => __('admin.sitename'),
            'description' => __('admin.description'),
            'default_lang' => __('admin.default_lang'),
            'perpage' => __('admin.perpage'),
            'up_vote_points' => __('admin.up_vote_points'),
            'down_vote_points' => __('admin.down_vote_points'),
            'best_answer_points' => __('admin.best_answer_points'),

        ];

        $this->validate($request, $rules, [], $attributes);

        Settings::set('sitename', $request->sitename);
        Settings::set('description', $request->description);
        Settings::set('default_lang', $request->default_lang);
        Settings::set('perpage', $request->perpage);
        Settings::set('up_vote_points', $request->up_vote_points);
        Settings::set('down_vote_points', $request->down_vote_points);
        Settings::set('best_answer_points', $request->best_answer_points);

        return redirect()->route('admin.settings')->with('success', __('lang.success'));
    }
}
