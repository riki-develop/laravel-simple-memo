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
        /** 
         * ▼ ここでメモ一覧を取得 
         * ・ ログインユーザーで絞り込み
         * ・ deleted_atがNnullだったら表示…論理削除を定義
         * ・ 出力→　降順
        */
        $memos = Memo::select('memos.*')
            ->where('user_id', '=', \Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('updated_at', 'DESC') // ASC=昇順　　DESC=降順
            ->get();

            // dd($memos);

        return view('create', compact('memos'));
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

    public function edit($id)
    {
        /** 
         * ▼ 
         * ・ 
         * ・ 
         * ・ 
        */
        $memos = Memo::select('memos.*')
            ->where('user_id', '=', \Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('updated_at', 'DESC') // ASC=昇順　　DESC=降順
            ->get();

        $edit_memo = Memo::find($id);

        return view('edit', compact('memos', 'edit_memo'));
    }
}
