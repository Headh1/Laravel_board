<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boards;

class ApiListController extends Controller
{
    function getlist($id) {
        $boards = Boards::find($id);
        return response()->json([$boards],200);
    }

    function postlist(Request $req) {
        $boards = new Boards([
            'title' => $req->title
            ,'content' => $req->content
        ]);
        
        $boards->save();

        $arr['errorcode'] = '0';
        $arr['msg'] = 'success';
        $arr['data'] = $boards->only('id','title');

        return $arr;
    }
}