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
    Schema::create('tbl_students', function (Blueprint $table) {
        $table->id('student_id');
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('class_id');
        $table->string('full_name', 100);
        $table->string('nis', 20)->unique();
        $table->date('date_of_birth')->nullable();
        $table->tinyInteger('archived')->default(0);
        $table->timestamps();

        // Relasi
        $table->foreign('user_id')->references('user_id')->on('tbl_users')->onDelete('cascade');
        $table->foreign('class_id')->references('class_id')->on('tbl_classes')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
