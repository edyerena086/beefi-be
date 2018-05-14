<?php

namespace MetodikaTI\Http\Controllers;

use Illuminate\Http\Request;
use MetodikaTI\Http\Requests\Account\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{
    /**
     * AuthController constructor.
     *
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * This method render login view to the user
     *
     * @return View
     */
    public function home()
    {
        return view('auth.login');
    }


    /**
     * This method allows or denied access to the system
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
            'user_group_id' => 2
        ];

        if (Auth::attempt($data))
        {
            return redirect()->intended('dashboard');
        }
        else
        {
            //Redirect the user to home
            Session::flash('loginError', true);

            //echo $request->email;

            return redirect()->intended('/');
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->intended('/');
    }
}
