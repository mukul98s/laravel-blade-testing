<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function store()
    {
        $formFields = request()->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6'
        ]);

        $formFields['password'] = bcrypt($formFields['password']);

        $user = User::create($formFields);

        auth()->login($user);

        return redirect('/')->with('message', 'User created and logged in!!');
    }

    public function create()
    {
        return view('user.register');
    }

    public function logout()
    {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/')->with('message', 'Logged, Out!');
    }

    public function login()
    {
        return view('user.login');
    }

    public function login_account()
    {
        $form = request()->validate([
            'email' => 'required|email'  ,
            'password' => 'required'
        ]);

        if(auth()->attempt($form)) {
            request()->session()->regenerate();
            return redirect('/')->with('message', 'Logged, In!');
        }

        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }
}
