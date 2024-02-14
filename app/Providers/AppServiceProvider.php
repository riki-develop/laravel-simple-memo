<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Memo;

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
             * HomeControllerのindexメソッドから移植
             * editメソッドに同じ定義がされていたので削除→ここでまとめる
             */
            $memos = Memo::select('memos.*')
                ->where('user_id', '=', \Auth::id())
                ->whereNull('deleted_at')
                ->orderBy('updated_at', 'DESC') // ASC=昇順　　DESC=降順
                ->get();

                /**
                 * ▼Viewに渡す処理
                 * ・第1引数はViewで使う時の命名
                 * ・第2引数はViewに渡したい変数or配列
                 */
                $view->with('memos', $memos);
        });
    }
}
