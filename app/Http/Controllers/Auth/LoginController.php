<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

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

    protected function authenticated() {
         if (Auth::user()->role == 'Admin') {
            return redirect('/home');
         } else if (Auth::user()->role == '1'|| Auth::user()->role == '2'|| Auth::user()->role =='3'|| Auth::user()->role == '4'|| Auth::user()->role =='5'|| Auth::user()->role =='6'|| Auth::user()->role == '7') {
            return redirect('/nodebReg');
         } else {
            return redirect('/home');
         }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
