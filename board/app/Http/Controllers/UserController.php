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
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

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
            $error = '아이디 비번 확인해주세요';
            return redirect()->back()->with('error', $error);
        }

        Auth::login($user);
        if(Auth::check()) {
            session($user->only('id'));
            return redirect()->intended(route('boards.index'));
        }
        else {
            $error = '유저 인증 작업 에러';
            return redirect()->back()->with('error',$error);
            
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
            // $errors[] = '회원가입 실패';
            // $errors[] = '다시 시도 ';
            $error = '회원가입 실패 <br> 다시 시도 해 ';

            return redirect()->route('users.sign')->with('error',$error);
        }
        return redirect()->route('users.login')->with('success','회원가입 완료 로그인 해주세요');
    }

    function logout() {
        Session::flush();
        Auth::logout();
        return redirect()->route('users.login');
    }

    function withraw() {
        $id = session('id');
        // return session()->all();
        $result = User::destroy($id);
        Session::flush();
        Auth::logout();
        // 에러 핸들링 구현하기
        return redirect()->route('users.login');
    }

    function myinfo() {
        $id = session('id');
        $user = User::find($id);
        // $user = User::find(Auth::User()->id);
        return view('myinfo')->with('data', $user);
    }

    function myinfoput(Request $req) {
        $arrK = []; // 수정할 항목을 배열에 담는 변수

        $baseUser = User::find(Auth::User()->id);

        if(!Hash::check($req->nowPw, $baseUser->password)){
            return redirect()->back()->with('error', '기존 비밀번호를 확인해');
        }

        if($req->name !== $baseUser->name) {
            $arrK[] = 'name';
        }
        if($req->email !== $baseUser->email) {
            $arrK[] = 'email';
        }
        if(isset($req->password))  {
            $arrK[] = 'password';
        }

        // 유효성체크를 하는 모든 항목 리스트
        $chkList = [
        'name' => 'required|regex:/^[가-힣]+$/|min:2|max:30'
        ,'email' => 'required|email|max:100'
        ,'nowPw' => 'regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{3,20}$/'
        ,'password' => 'same:passck|regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{3,20}$/'
    ];


        // 수정할 항목ㅇ르 배열에 담는 처리

        // $id = session('id');
        // $user = User::find($id);
        // $arr = ['id'=>$id];
        // $request->request->add($arr);

        // $req->validate([
        //     'id' => 'required|integer'
        //     ,'name' => 'required|regex:/^[가-힣]+$/|min:2|max:30'
        //     ,'email' => 'required|email|max:100'
        //     ,'password' => 'required_with:passck|same:passck|regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{3,20}$/'
        // ]);

        // 유효성 체크할 항목 셋팅하는 처리
        $arrck['nowPw'] = $chkList['nowPw'];
        foreach($arrK as $val) {
            $arrck[$val] = $chkList[$val];
        }

        // $result = User::find($id);
        // $result->name = $req->name;
        // $result->email = $req->email;
        // $result->save();

        
        $req->validate($arrck);
        
        // 수정할 데이터 셋팅
        foreach($arrK as $val) {
            if($val === 'password') {
                $baseUser->$val = Hash::make($req->$val);
                continue;
            }
            $baseUser->$val = $req->$val;
        }
        
        // update
        $baseUser->save();

        // $result = User::destroy($id);
        Session::flush();
        Auth::logout();

        // return redirect()->route('users.myinfo');
        return redirect()->route('users.login');
        // return redirect('/users/'.$id)->with('data', User::findOrFail($id));
    }
}
