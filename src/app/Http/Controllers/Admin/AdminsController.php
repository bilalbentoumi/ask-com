<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ADminsController extends Controller {

    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index() {
        $admins = Admin::all();
        return view('admin.admins.index', compact('admins'));
    }

    public function show($id) {
        $admin = Admin::findOrFail($id);
        return view('admin.admins.show', compact('admin'));
    }

    public function create() {
        return view('admin.admins.create');
    }

    public function store(Request $request) {

        $rules = [
            'first_name'            => 'required',
            'last_name'             => 'required',
            'email'                 => 'required|unique:users',
            'password'              => 'required|min:8'
        ];
        $attributes = [
            'first_name'            => __('admin.first_name'),
            'last_name'             => __('admin.last_name'),
            'email'                 => __('admin.email'),
            'password'              => __('admin.password'),
        ];
        $this->validate($request, $rules, [], $attributes);

        $admin = new Admin();
        $admin->first_name = $request->first_name;
        $admin->last_name = $request->last_name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->save();

        if ($request->has('create_another'))
            return redirect()->route('admins.create')->with('success', __('lang.success'));

        return redirect()->route('admins.index')->with('success', __('lang.success'));
    }

    public function edit($id) {
        $admin = Admin::findOrFail($id);
        return view('admin.admins.edit', compact('admin'));
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

        $admin = Admin::findOrFail($id);
        $admin->first_name = $request->first_name;
        $admin->last_name = $request->last_name;
        $admin->email = $request->email;
        if ($request->password != '') {
            $admin->password = Hash::make($request->password);
            $logout = true;
        }
        $admin->save();

        return redirect()->route('admins.index')->with('success', __('lang.success'));
    }

    public function destroy($id) {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        return redirect()->route('admins.index')->with('success', __('lang.success'));
    }

}
