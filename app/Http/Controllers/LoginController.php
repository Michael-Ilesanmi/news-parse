<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Display Login Page.
     * @return View
     */
    public function show() : View 
    {
        return view('auth.login'); 
    }


    /**
     * Sign out user.
     * @return RedirectResponse
     */
    public function logout() : RedirectResponse 
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/login');
    }

    /**
     * Authenticate user
     * @return RedirectResponse
     */
    public function store(LoginRequest $request) 
    {
        $credentials = $request->safe()->only(['email', 'password']);
        $limiter = RateLimiter::for('login:'.$credentials['email'], function () {
            return 5; // limit to 5 attempts every 60 seconds
        }, 60);
    
        if ($limiter->tooManyAttempts('login:'.$credentials['email'], 5)) {
            flash()->addError('Too many login attempts. Please try again later.');
            return back()->withErrors([
                'email' => 'Too many login attempts. Please try again later.',
            ])->onlyInput('email');
        }
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $limiter->clear('login:'.$credentials['email']);
            flash()->addSuccess('Login Successfull');
            return redirect()->intended('/');
        }

        $limiter->hit('login:'.$credentials['email']);
        flash()->addError('The provided credentials do not match our records.');
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');  
    }
}
