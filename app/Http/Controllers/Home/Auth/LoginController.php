<?php

namespace App\Http\Controllers\Home\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('home.auth.login');
    }

    public function username()
    {
        return 'username';
    }

    public function attemptLogin(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        // 验证身份证登录方式
        $login = $this->guard()->attempt(
            ['id_number' => $username, 'password' => $password], $request->has('remember')
        );

        if ($login) {
            return true;
        }

        // 验证手机号登录方式
        $login = $this->guard()->attempt(
            ['phone' => $username, 'password' => $password], $request->has('remember')
        );

        if ($login) {
            return true;
        }

        // 验证用户名登录方式
        $login = $this->guard()->attempt(
            ['name' => $username, 'password' => $password], $request->has('remember')
        );

        if ($login) {
            return true;
        }

        return false;
    }
}
