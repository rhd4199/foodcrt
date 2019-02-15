<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');
        // dd($email,$password);

        if (Auth::attempt(['email'=>$email,'password'=>$password])) 
        {
            return redirect('/dashboard');
        }
        else 
        {
            echo "email atau password salah<br/>";
            echo "<a href='/'>kembali</a>";
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
