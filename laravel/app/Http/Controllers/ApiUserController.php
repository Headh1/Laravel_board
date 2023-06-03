<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiUserController extends Controller
{
    public function getuser($email) {
        $arr = [
            'code' => '0'
            ,'msg' => ''
        ];
        $user = DB::select('select name, email from users where email = ?', [$email] );
        if($user) {
            $arr['code'] = '0';
            $arr['msg'] = 'success Get User';
            $arr['data'] = $arr[0];
        } else {
            $arr['code'] = 'E01';
            $arr['msg'] = 'No Data';
        }

        return $arr;
    }

    public function postuser(Request $req) {
        $arr = [
            'code' => '0'
            ,'msg' => ''
        ];
        $re = DB::insert(' INSERT into users (name,email,password) VALUES(?,?,?)',[
            $req->name , $req->email , Hash::make($req->password)
        ]);

        if($re) {
            $arr['code'] = '0';
            $arr['msg'] = 'Success Registration';
            $arr['data'] = [$req->email];
        } else {
            $arr['code'] = 'E01';
            $arr['msg'] = 'No Data';
        }
        return $arr;
        }

    public function putuser(Request $req , $email) {
        $arr = [
            'code' => '0'
            ,'msg' => ''
        ];
        $re = DB::update(' update users set name = ? where = ? ' ,[
            $req->name , $email
        ]);

        if($re) {
            $arr['code'] = '0';
            $arr['msg'] = 'Success Registration';
            $arr['data'] = [$req->name];
        } else {
            $arr['code'] = 'E01';
            $arr['msg'] = 'No Data';
        }
        return $arr;
    }

    public function deleteuser($email) {
        $arr = [
            'code' => '0'
            ,'msg' => ''
        ];
        $date = Carbon::now();
        $re = DB::update(' update users set delFlg = ? , deleted_at = ? where = ? ' ,[
            '1' , $date , $email
        ]);

        if($re) {
            $arr['code'] = '0';
            $arr['msg'] = 'Success Registration';
            $arr['data'] = ['deleted_at' => $date, 'email'=>$email];
        } else {
            $arr['code'] = 'E01';
            $arr['msg'] = 'No Data';
        }
        return $arr;
    }
}
