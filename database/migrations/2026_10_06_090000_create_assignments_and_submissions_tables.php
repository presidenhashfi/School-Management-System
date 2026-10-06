<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_assignments', function (Blueprint $table) {
            $table->id('assignment_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('created_by');
            $table->string('title', 150);
            $table->longText('description'); // HTML dari rich text editor (sudah disanitasi)
            $table->dateTime('due_at')->nullable();
            $table->tinyInteger('archived')->default(0);
            $table->timestamps();

            $table->foreign('subject_id')->references('subject_id')->on('tbl_subjects')->onDelete('cascade');
            $table->foreign('created_by')->references('user_id')->on('tbl_users')->onDelete('cascade');
        });

        Schema::create('tbl_submissions', function (Blueprint $table) {
            $table->id('submission_id');
            $table->unsignedBigInteger('assignment_id');
            $table->unsignedBigInteger('student_id');
            $table->string('file_path');
            $table->string('original_name');
            $table->unsignedInteger('file_size');
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamps();

            $table->unique(['assignment_id', 'student_id']);
            $table->foreign('assignment_id')->references('assignment_id')->on('tbl_assignments')->onDelete('cascade');
            $table->foreign('student_id')->references('student_id')->on('tbl_students')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_submissions');
        Schema::dropIfExists('tbl_assignments');
    }
};
