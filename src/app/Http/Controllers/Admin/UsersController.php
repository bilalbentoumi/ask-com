<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller {

    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index() {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function show($id) {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit($id) {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id) {

        $rules = [
            'first_name'            => 'required',
            'last_name'             => 'required',
            'email'                 => 'required|unique:users,email,' . $id,
            'password'              => 'nullable|min:8'
        ];
        $attributes = [
            'first_name'            => __('admin.first_name'),
            'last_name'             => __('admin.last_name'),
            'email'                 => __('admin.email'),
            'password'              => __('admin.password'),
        ];
        $this->validate($request, $rules, [], $attributes);

        $user = User::findOrFail($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->status = $request->status ? 1 : 0;
        if ($request->password != '') {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('users.index')->with('success', __('lang.success'));
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', __('lang.success'));
    }

}
