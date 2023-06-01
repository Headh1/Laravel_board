<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boards;
use Illuminate\Support\Facades\Validator;

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

    function putlist(Request $request,$id) {
        $arrData = [
            'code' => '0'
            ,'msg' => ''
            // ,'org_data' => []
            // ,'udt_data' => []
        ];
        
        $data = $request->only('title','content');
        $data['id']= $id;

        $validator = Validator::make($data, [
            'id' => 'required|integer|exists:boards',
            'title' => 'required|between:3,30',
            'content' => 'required|max:1000']);

        if ($validator->fails()) {
            $arrData['code'] = 'E01';
            $arrData['msg'] = 'error';
            $arrData['errmsg'] = $validator->errors()->all();
        }else { 
            $boards = Boards::find($id);
            $boards->title = $request->title;
            $boards->content = $request->content;
            $boards->save();
            $arrData['code'] = '0';
            $arrData['msg'] = 'success';
        }

        return $arrData;

        // $validator = Validator::make($request->only('id','title','content'),[
        //     'id' => 'required|integer'
        //     ,'title'=>'required|between:3,30'
        //     ,'content'=>'required|max:1000'
        // ]);

    //     $boards = Boards::find($id);
    //     $boards->title = $request->title;
    //     $boards->content = $request->content;
    //     $boards->save();

    //     $arrr['errorcode'] = '0';
    //     $arrr['msg'] = 'success';
    //     $arrr['data'] = $boards->only('id','title','content');

    //     return $arrr;
    // }
        } 

    function deletelist($id) {
        $arrData = [
            'code' => '0'
            ,'msg' => ''
            // ,'org_data' => []
            // ,'udt_data' => []
        ];
        $data['id']= $id;
        $validator = Validator::make($data, [
            'id' => 'required|integer|exists:boards',]);
        if ($validator->fails()) {
            $arrData['code'] = 'E01';
            $arrData['msg'] = 'error';
            $arrData['errmsg'] = 'id not found';
        }else { 
            $boards = Boards::find($id);
            if($boards){
                $boards->delete();
                $arrData['code'] = '0';
                $arrData['msg'] = 'success';
            }else{
            $arrData['code'] = 'E01';
            $arrData['msg'] = 'Already Deleted';
            }
        }
        return $arrData;

        // $boards = Boards::find($id)->delete();
        
        // $arrr['errorcode'] = '0';
        // $arrr['msg'] = 'success';

        // return $arrr;
}
}