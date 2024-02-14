<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    use HasFactory;

    public function getMyMemo() {
        // リクエストファザードを使ってURLパラメータを取得
        // 通常useで宣言して使うclassだがバックスラッシュを付ける事で単発使用可になる
        $query_tag = \Request::query('tag');

        // ========== ベースメソッドを定義 ==========
        $query = Memo::query()->select('memos.*')
            ->where('user_id', '=', \Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('updated_at', 'DESC');
        // ========== ベースメソッドを定義 ==========

        if(!empty($query_tag)) {
            // ▼もしtag_URLクエリパラメータがあればタグで絞り込み
            $query->leftJoin('memo_tags', 'memo_tags.memo_id', '=', 'memos.id')
            ->where('memo_tags.tag_id', '=', $query_tag);
        }

        $memos = $query->get();

        return $memos;
    }
}