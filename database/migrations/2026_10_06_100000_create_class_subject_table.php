<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Mapel yang dipelajari tiap kelas; siswa mengikuti mapel kelasnya.
        Schema::create('tbl_class_subject', function (Blueprint $table) {
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('subject_id');

            $table->primary(['class_id', 'subject_id']);
            $table->foreign('class_id')->references('class_id')->on('tbl_classes')->onDelete('cascade');
            $table->foreign('subject_id')->references('subject_id')->on('tbl_subjects')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_class_subject');
    }
};
