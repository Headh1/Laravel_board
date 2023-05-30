<?php
/************************************
 *  프로젝트명 : laravel_board
 *  디렉토리   : controllers
 *  파일명     : UserController.php
 *  이력       : v001 0530 JA.KIM new
 ************************************/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function login() {
        return view('login');
    }

    function loginpost(Request $req) {
        $req->validate([
            'email' => 'required|email|max:100'
            ,'password' => 'required|regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{3,20}$/'
        ]);

        $user = User::where('email', $req->email)->first();
        if(!$user || !(Hash::check($req->password, $user->password))) {
            $errors[] = '아이디 비번 확인해주세요';
            return redirect()->back()->with('errors',collect($errors));
        }

        Auth::login($user);
        if(Auth::check()) {
            session([$user->only('id')]);

            return redirect()->intended(route('boards.index'));
        }
        else {
            $errors[] = '유저 인증 작업 에러';
            return redirect()->back()->with('errors',collect($errors));
        }


    }

    function sign() {
        return view('sign');
    }

    function signpost(Request $req) {
        $req->validate([
            'name' => 'required|regex:/^[가-힣]+$/|min:2|max:30'
            ,'email' => 'required|email|max:100'
            ,'password' => 'required_with:passck|same:passck|regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{3,20}$/'
        ]);

        $data['name'] = $req->name;
        $data['email'] = $req->email;
        $data['password'] = Hash::make($req->password);

        $user = User::create($data);
        if(!$user) {
            $errors[] = '회원가입 실패';
            $errors[] = '다시 시도 ';

            return redirect()->route('users.sign')->with('errors',collect($errors));
        }

        return redirect()->route('users.login')->with('success','회원가입 완료 로그인 해주세요');
    }
}
