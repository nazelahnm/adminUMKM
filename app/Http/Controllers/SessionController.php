<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SessionController extends Controller
{
    
    function index()
    {
        return view("admin/sesi/index");
    }
    function login(Request $request)
    {
        Session::flash('email', $request->email);
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ],[
            'email.required' => 'email is required',
            'password.required' => 'Password is required'
        ]);

        $infologin = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($infologin)){
            //jika autentifikasi sukses
            return redirect('dashboard')->with('success', 'Login Successful');
        }else{
            //jika autentifikasi gagal
            // return 'gagal';
            return redirect('sesi')->withInput()->withErrors([
                'email' => 'The email and password entered are invalid',
                'password' => 'The email and password entered are invalid'
            ]);            
        }
    }

    function logout(){
        Auth::logout();
        return redirect('/dashboard')->with('success', 'Berhasil logout');
    }
}
