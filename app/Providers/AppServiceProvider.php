<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Memo;
use App\Models\Tag;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 全てのメソッドが呼ばれる前に先に呼ばれるメソッド
        view()->composer('*', function ($view) {

            // リクエストファザードを使ってURLパラメータを取得
            // 通常useで宣言して使うclassだがバックスラッシュを付ける事で使用可能になる
            $query_tag = \Request::query('tag');

            if(!empty($query_tag)) {
                // ▼もしtag_URLクエリパラメータがあればタグで絞り込み
                $memos = Memo::select('memos.*')
                    ->leftJoin('memo_tags', 'memo_tags.memo_id', '=', 'memos.id')
                    ->where('memo_tags.tag_id', '=', $query_tag)
                    ->where('user_id', '=', \Auth::id())
                    ->whereNull('deleted_at')
                    ->orderBy('updated_at', 'DESC') // ASC=昇順　　DESC=降順
                    ->get();
            }else{
                // ▼tag_URLクエリパラメータが無ければすべて取得
                $memos = Memo::select('memos.*')
                    ->where('user_id', '=', \Auth::id())
                    ->whereNull('deleted_at')
                    ->orderBy('updated_at', 'DESC') // ASC=昇順　　DESC=降順
                    ->get();
            }

            /**
             * タグ絞り込み機能実装に当たり、ここで定義→Viewに渡す
             */
            $tags = Tag::where('user_id', '=', \Auth::id())
                ->whereNull('deleted_at')
                ->orderBy('id', 'DESC')
                ->get();

            /**
             * ▼Viewに渡す処理
             * ・第1引数はViewで使う時の命名
             * ・第2引数はViewに渡したい変数or配列
             */
            $view->with('memos', $memos)->with('tags', $tags);
        });
    }
}
