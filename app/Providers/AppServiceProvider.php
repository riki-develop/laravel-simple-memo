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
            /**
             * 自分のメモデータ取得は「app/Models/Memo.php」で定義
             */
            $memo_model = new Memo(); // インスタンス化
            $memos = $memo_model->getMyMemo();

            // タグ絞り込み機能実装に当たり、ここで定義→Viewに渡す
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
