<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function authenticate(Request $request)
    {
        // dd($request->remember); is null if not on
        // dd($request->all());
        $credentials = $request->only('email', 'password');
        // dd(Auth::attempt($credentials));
 
        if (Auth::attempt($credentials)) {
            // Authentication passed...
          //  if (Auth::user()->compagnie_id == 23) {
                # l'utilisateur doit être de la compagnie SMT = 23

                if(Auth::user()->usertype == "admin" || Auth::user()->usertype == "chefgare" || Auth::user()->usertype == "caissiere" || Auth::user()->usertype == "comptable")
                {
                    return redirect()->intended();
                }

          //  }
            Auth::logout();
            return back()->withError("Vous devez être Administrateur pour accéder à cette plateforme !");
        }
        else
        {
            return back()->withError("Login ou mot de passe incorrect !");
        }
    }
}
