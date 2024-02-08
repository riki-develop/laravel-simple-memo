<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemoTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memo_tags', function (Blueprint $table) {
            // 外部Key成約がある場合は【unsignedBigInteger】で定義する 
            $table->unsignedBigInteger('memo_id');
            $table->unsignedBigInteger('tag_id');

            // 外部Key成約
            $table->foreign('memo_id')->references('id')->on('memos');
            $table->foreign('tag_id')->references('id')->on('tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('memo_tags');
    }
}
