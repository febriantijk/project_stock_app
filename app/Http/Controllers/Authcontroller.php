<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authcontroller extends Controller
{
  public function index()
  {
    return view (view:'Auth.login');
  }

  public function register()
  {
    return view (view:'Auth.register');
  }

  public function login(request $request)
  {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6'
        ], [
            //ini bahasa indonesia
            'email.required' => 'Form Wajib di isii!!!',
            'email.email' => 'silahkan isi dengan format @gmail.com',
            'email.exists' => 'maaf email belum terdaftar',



            'password.required' => 'password wajib di isi!!!',
            'password.min' => 'password minimal 6 karakter',
        ]);


        $infologin = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if(Auth::attempt($infologin)) {
            return redirect('/dashboard');
        } else {
            return redirect()->back()->withErrors([
                'email' => 'email tidak sesuai',
                'password' => 'password tidak sesuai',
            ]);
        }
    }
    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}


