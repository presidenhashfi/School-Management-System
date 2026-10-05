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
    Schema::create('tbl_classes', function (Blueprint $table) {
        $table->id('class_id');
        $table->string('class_name', 50);
        $table->unsignedBigInteger('homeroom_teacher_id')->nullable(); 
        $table->string('academic_year', 20);
        $table->tinyInteger('archived')->default(0);
        $table->timestamps();

        // Relasi (Wali Kelas)
        $table->foreign('homeroom_teacher_id')->references('teacher_id')->on('tbl_teachers')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
