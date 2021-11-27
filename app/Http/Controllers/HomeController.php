<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Modelをインポート
use App\Models\memo;

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
        //ここでメモをDBから取得
        //ログインしているユーザーの情報のみ取得
        $memos = Memo::select('memos.*')
               ->where('user_id', '=', \Auth::id()) //ここでログインユーザー判定
               ->whereNull('deleted_at')
               ->orderBy('updated_at', 'DESC') //ASC=小さい順、DESC=大きい順
               ->get();

        //dd($memos);

        // compact関数を使ってbladeテンプレートに値を渡す
        return view('create', compact('memos'));
    }

    // store関数を定義
    public function store(Request $request)
    {
        $posts = $request->all();

        // dump_dieの略 → メソッドの引数の取った値を展開して止める
        // →データの値を確認するデバック関数
        // dd(\Auth::id());

        // memosテーブルへ紐付け：配列定義
        Memo::insert(['content' => $posts['content'], 'user_id' => \Auth::id()]);

        // homeにリダイレクト
        return redirect( route('home') );
    }
}
