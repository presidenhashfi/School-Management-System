<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_activity_logs', function (Blueprint $table) {
            $table->id('log_id');
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('username', 50)->nullable();
            $table->string('role', 20)->nullable();
            $table->string('action', 30)->index();   // login, logout, login_failed, created, updated, deleted, password_changed
            $table->string('subject_type', 50)->nullable();
            $table->string('subject_id', 20)->nullable();
            $table->text('description');
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_activity_logs');
    }
};
