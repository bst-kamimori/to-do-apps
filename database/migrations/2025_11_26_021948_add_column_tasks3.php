<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTasks3 extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->integer('is_recurring')->nullable();
            $table->integer('recurrence')->nullable();
            $table->integer('next_run_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('is_recurring');
            $table->dropColumn('recurrence');
            $table->dropColumn('next_run_at');
        });
    }
}
