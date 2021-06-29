<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use \App\User;

use Illuminate\Http\Request;

use App\Events\PusherEvent;

class LoginController extends Controller
{
    /**
     * Validate the user login.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        if ( auth()->attempt(['email' => $req->email, 'password' => $req->password]) ) {
            if(Auth::user()->tipo_usuario == 1) {
                return redirect()->to('/productos');
            } else {
                return redirect()->to('/realizar-pedido');
            }
        } else {
            auth()->logout();
        }
        return redirect()->to('/login');
    }

    /**
     * Destroy's the current session.
     *
     */
    public function logout() 
    {
        auth()->logout();
        session()->forget('msg');
        return redirect('/login');
    }
}
