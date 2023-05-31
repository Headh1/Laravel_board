<?php
/******************************
 *  프로젝트명 : laravel_board
 *  디렉토리   : controllers
 *  파일명     : BoardsController.php
 *  이력       : v001 0526 JA.KIM new
 *               v002 0530 JA.KIM 유효성 체크 추가
 *****************************/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\boards;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BoardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->guest()) {
            return redirect()->route('users.login');
        }
        $result = Boards::select(['id','title','hits','created_at','updated_at'])->orderBy('hits','desc')->get();
        return view('list')->with('data',$result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('write');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        // v002 add atart
        $req->validate([
            'title'=>'required|between:3,30'
            ,'content'=>'required|max:1000'
        ]);
        // v002 add end
        $boards = new Boards([
            'title' => $req->input('title')
            ,'content' => $req->input('content')
        ]);
        $boards->save();
        return redirect('/boards');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $boards = Boards::find($id);
        $boards->hits++;
        $boards->save();
        return view('detail')->with('data', Boards::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $boards = Boards::find($id);
        
        return view('edit')->with('data', $boards);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // v002 add atart
        $arr = ['id'=>$id];
        // $request->merge($arr);
        $request->request->add($arr);

        $request->validate([
            'id' => 'required|integer'
            ,'title'=>'required|between:3,30'
            ,'content'=>'required|max:1000'
        ]);
        // v002 add end
        
        // $validator = Validator::make($request->only('id','title','content'),[
        //     'id' => 'required|integer'
        //     ,'title'=>'required|between:3,30'
        //     ,'content'=>'required|max:1000'
        // ]);

        // if($validator->fails()) { 
        //     return redirect()->back()->withErrors($validator)->withInput();
        // };

        // DB::table('boards')->where('id',$id)->update([
        //     'title' => request('title'),
        //     'content' => request('content'),
        // ]);


        $result = Boards::find($id);
        $result->title = $request->title;
        $result->content = $request->content;
        $result->save();
        
        return redirect()->route('boards.show', ['board' => $id]);
        // return redirect('/boards/'.$id)->with('data', Boards::findOrFail($id));
        // return view('detail')->with('data', Boards::findOrFail($id));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $boards = Boards::find($id);
        $boards = DB::update('update boards set deleted_at = NOW() where id = :id', ['id'=>$id] );
        // $boards->save();
        // return redirect('/boards');
        // $boards->delete();
        return redirect('/boards');
    }
}
