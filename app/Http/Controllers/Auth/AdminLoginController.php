<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class AdminLoginController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function login()
    {
        return view('admin.auth.signin');
    }

    public function loginAdmin(Request $request)
    {

        $rules = [
            'email' => 'required|string',
            'password' => 'required|min:8',
        ];

        $attributes = [
            'email' => __('admin.email'),
            'password' => __('admin.password'),
        ];

        $this->validate($request, $rules, [], $attributes);

        if (Auth::guard('admin')->attempt([
            'email' => $request->email, 'password' => $request->password
        ], $request->remember)) {
            // if successful, then redirect to their intended location
            return redirect()->intended(route('admin.home'));
        }
        // if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
