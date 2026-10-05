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
    Schema::create('tbl_teachers', function (Blueprint $table) {
        $table->id('teacher_id');
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('subject_id');
        $table->string('full_name', 100);
        $table->string('nip', 20)->unique();
        $table->tinyInteger('archived')->default(0);
        $table->timestamps();

        // Relasi
        $table->foreign('user_id')->references('user_id')->on('tbl_users')->onDelete('cascade');
        $table->foreign('subject_id')->references('subject_id')->on('tbl_subjects')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
