<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BoardController extends Controller
{
    function list(){
        $r = DB::select(' SELECT * from boards');

        return view('list')->with('list',$r);
    }

    function write(){
        return view('write');
    }

    function writepost(Request $req) {
        $v = Validator::make($req->only('title','content') , [
            'title' => 'required|min:3|max:30'
            ,'content' => 'required|max:900'
        ]);

        if($v->fails()) {
            return redirect()->back()->withErrors($v);
        }

        DB::insert('insert into boards (title , content , write_user_id) values (?, ?, 1)', [
            $req->title,
            $req->content
    ]);

    return redirect('/boards/list');
    }
}
