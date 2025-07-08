<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');//user_idはunsignedBigInteger型と決まっている

            // 外部キー制約
            $table->foreign('user_id')->references('id')->on('users');//テーブル名はtasks　外部キーにするカラムはuser_id 参照先のテーブル名はusers 参照するカラムは通常は id（主キー）
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            //外部キー制約の削除
            $table->dropForeign(['user_id']);

            // カラムの削除
            $table->dropColumn('user_id');
        });
    }
};
