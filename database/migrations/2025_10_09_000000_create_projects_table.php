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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            // 基本情報
            $table->string('name')->comment('案件名');
            $table->string('code')->nullable()->unique()->comment('案件コード');
            $table->string('client_name')->nullable()->comment('顧客名');
            $table->string('status')->default('active')->comment('ステータス: active, on_hold, completed など');
            // 期間
            $table->date('start_date')->nullable()->comment('開始日');
            $table->date('end_date')->nullable()->comment('終了日');
            // メモ
            $table->text('description')->nullable()->comment('備考');
            // フラグ
            $table->boolean('is_archived')->default(false)->comment('アーカイブ済み');

            $table->softDeletes();
            $table->timestamps();

            $table->unique(['name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
