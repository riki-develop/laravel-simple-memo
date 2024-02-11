<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memo;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        /** 
         * POSTの場合は取りあえずRequestファザードを定義しておく ->　(Request $request)
         * 引数に定義しておく事でHttpに関わる様々なメソッドが使える様になる
        */
        $posts = $request->all();

        // dump_dieの略 -> メソッドの引数に取った値を展開して止める（デーだの確認をするデバッグ関数）
        // dd($posts);

        // Memoモデルに接続-> ユーザーから受け取ったcontentとuser_idを一致させる
        Memo::insert([
            'content' => $posts['content'],
            'user_id' => \Auth::id()
        ]);

        return redirect( route('home') );
    }
}
