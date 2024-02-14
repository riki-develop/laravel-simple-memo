<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memo;
use App\Models\Tag;
use App\Models\MemoTag;
use DB;

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
         * ▼ ここでタグ一覧を取得 
         * ・ ログインユーザーで絞り込み
         * ・ deleted_atがNnullだったら表示…論理削除を定義
         * ・ 出力→　降順
        */
        $tags = Tag::where('user_id', '=', \Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('id', 'DESC') // ASC=昇順　　DESC=降順
            ->get();

        //compact関数で取得したデータをviewに配列で渡す
        return view('create', compact('tags'));
    }

    public function store(Request $request)
    {
        /** 
         * POSTの場合は取りあえずRequestファザードを定義しておく ->　(Request $request)
         * 引数に定義しておく事でHttpに関わる様々なメソッドが使える様になる
        */
        $posts = $request->all();

        // ====== ここからトランザクション開始 ======
        DB::transaction(function() use($posts) {

            // ここでinsertするのではなく、中間テーブルに登録するためinsertGetIdでmemo_idを取得
            $memo_id = Memo::insertGetId([
                'content' => $posts['content'],
                'user_id' => \Auth::id()
            ]);

            // ログインユーザーが同じタグを登録していないかexistsを使ってチェック
            $tag_exists = Tag::where('user_id', '=', \Auth::id())->where('name', '=', $posts['new_tag'])->exists();

            // 新しいタグが入力されている、かつ、すでに登録されているタグが存在しなければ登録
            if(!empty($posts['new_tag']) && !$tag_exists) {
                // ここでinsertするのではなく、中間テーブルに登録するためinsertGetIdでtag_idを取得
                $tag_id = Tag::insertGetId([
                    'user_id' =>  \Auth::id(),
                    'name' => $posts['new_tag']
                ]);

                // ここで上記で取得したmemo_idとtag_idをmemo_tagsテーブルにinsertする
                MemoTag::insert([
                    'memo_id' => $memo_id,
                    'tag_id' => $tag_id
                ]);
            }

            // 既存タグが紐づけられた場合→ memo_tagsテーブルにinsertする
            if(!empty($posts['tag'][0])) {
                foreach($posts['tags'] as $tag) {
                    MemoTag::insert([
                        'memo_id' => $memo_id,
                        'tag_id' => $tag
                    ]);
                }
            }
        });
        // ====== ここでトランザクション終了 ======

        return redirect( route('home') );
    }

    public function edit($id)
    {
        // leftJoinを使ってmemosテーブルとtagsテーブルを紐づけ
        $edit_memo = Memo::select('memos.*', 'tags.id AS tag_id')
            ->leftJoin('memo_tags', 'memo_tags.memo_id', '=', 'memos.id')
            ->leftJoin('tags', 'memo_tags.tag_id', '=', 'tags.id')
            ->where('memos.user_id', '=', \Auth::id())
            ->where('memos.id', '=', $id)
            ->whereNull('memos.deleted_at')
            ->get();

        // メモと関連するタグを取得（複数）
        $include_tags = [];
        foreach($edit_memo as $memo) {
            array_push($include_tags, $memo['tag_id']);
        }

        $tags = Tag::where('user_id', '=', \Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('id', 'DESC') // ASC=昇順　　DESC=降順
            ->get();

        // 上記で取得したデータをViewにわたす
        return view('edit', compact('edit_memo', 'include_tags', 'tags'));
    }

    public function update(Request $request)
    {
        $posts = $request->all();

        // ====== ここからトランザクション開始 ======
        DB::transaction(function() use($posts) {
            /**
             * ※注意点：　updateを使う際は「必ず」whereを使う！
             * 先にwhere()-> で更新行を指定しておかないとすべてのレコードが更新されてしまう
             */ 
            Memo::where('id', $posts['memo_id'])->update([
                'content' => $posts['content'],
                'user_id' => \Auth::id(),
            ]);

            // 一旦メモとタグの紐付けを解除（物理削除）
            MemoTag::where('memo_id', '=', $posts['memo_id'])->delete();

            // 再度メモとタグを紐付け
            foreach($posts['tags'] as $tag) {
                MemoTag::insert([
                    'memo_id' => $posts['memo_id'],
                    'tag_id' => $tag
                ]);
            }

            // ログインユーザーが同じタグを登録していないかexistsを使ってチェック
            $tag_exists = Tag::where('user_id', '=', \Auth::id())->where('name', '=', $posts['new_tag'])->exists();

            // 新しいタグが入力されている、かつ、すでに登録されているタグが存在しなければ登録
            if(!empty($posts['new_tag']) && !$tag_exists) {
                // ここでinsertするのではなく、中間テーブルに登録するためinsertGetIdでtag_idを取得
                $tag_id = Tag::insertGetId([
                    'user_id' =>  \Auth::id(),
                    'name' => $posts['new_tag']
                ]);

                // memo_idとtag_idをmemo_tagsテーブルにinsertする
                MemoTag::insert([
                    'memo_id' => $posts['memo_id'],
                    'tag_id' => $tag_id
                ]);
            }
        });
        // ====== ここでトランザクション終了 ======

        return redirect( route('home') );
    }

    public function destroy(Request $request)
    {
        $posts = $request->all();

        /**
         * ※注意点
         * delete文ではなく「update」を定義（物理削除ではなく論理削除を指定）
         */ 
        Memo::where('id', $posts['memo_id'])->update([
            'deleted_at' => date("y-m-d H:i:s", time())
        ]);

        return redirect( route('home') );
    }
}
