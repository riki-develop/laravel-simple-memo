<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memos', function (Blueprint $table) {
            // 外部Key成約がある場合は【unsignedBigInteger】で定義する 
            // 第2引数に【true】を定義するとオートインクリメントされる
            $table->unsignedBigInteger('id', true);
            $table->longText('content');
            $table->unsignedBigInteger('user_id');

            // 【softDeletes】は論理削除を定義 -> deleted_atが自動生成される
            $table->softDeletes();

            // ※timestampを定義する際の注意点
            // レコード挿入時・更新時にナウな値を入れるため　default　DB::rawで直接定義
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            // 外部Key成約
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('memos');
    }
}
