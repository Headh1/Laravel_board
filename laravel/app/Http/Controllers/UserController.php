<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login() {
        return view('login');
    }

    public function loginpost(Request $req) {
        Log::debug("Login Start", $req->only('email','password'));

        Log::debug("Validator Start");
        $validate = Validator::make($req->only('email','password') , [
            'email' => 'required|email|max:30'
            ,'password' => 'required|min:3|max:30'
        ]);
        Log::debug("Validator end");

        if($validate->fails()) {
            Log::debug("Validator fails Start");

            return redirect()->back()->withErrors($validate);
        }

        $user = DB::select('select id, email, password from users where email = ?',[
            $req->email
        ]);
        
        // if(!$user || !Hash::check($req->password , $user[0]->password)) {
            if(!$user || $req->password !== $user[0]->password) {
                return redirect()->back()->withErrors(["아이디 비번 확인바람."]);
            }

        Log::debug("Select user", [$user[0]]);
        Auth::loginUsingId($user[0]->id);
        if(!Auth::check()) {
            // session($user[0]->id);
            Log::debug("돌아가");
            return redirect()->back()->withErrors("돌아가");
        }else {
            Log::debug("오케이");
            return redirect("/");
        }
        // return redirect()->back();
    }
}