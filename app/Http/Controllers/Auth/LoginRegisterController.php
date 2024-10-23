<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\CheckAge;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;

class LoginRegisterController extends Controller
{
    public function register(){
        return view('auth.register');
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users,email',  
            'password' => 'required|min:8|confirmed'
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('books.index')->with('success', 'You have successsfully registered & logged in!');
    }
    public function login(){
        return view('auth.login');
    }
    public function dashboard(){
        if(Auth::check()){
            return view('dashboard');
        }
        return redirect()->route('login')->withErrors([
            'email' => 'Please login to access the dashboard.'
        ])->onlyInput('email');
    }
    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->route('books.index')->with('success', 'You have successsfully logged in!');
        }

        return back()->withErrors([
            'email' => 'Your provided credentials do not match in our records.'
        ])->onlyInput('email');
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'You have logged out successsfully!');
    }
}
