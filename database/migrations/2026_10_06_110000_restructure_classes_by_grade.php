<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_classes', function (Blueprint $table) {
            $table->string('grade', 3)->nullable()->after('class_name'); // X, XI, XII
            $table->string('section', 20)->nullable()->after('grade');   // A, B, C, ...
        });

        Schema::table('tbl_subjects', function (Blueprint $table) {
            $table->string('grade', 3)->nullable()->after('subject_name');
        });

        Schema::table('tbl_students', function (Blueprint $table) {
            $table->string('status', 10)->default('active')->after('class_id'); // active | graduated
        });

        Schema::table('tbl_assignments', function (Blueprint $table) {
            $table->unsignedBigInteger('class_id')->nullable()->after('subject_id');
            $table->foreign('class_id')->references('class_id')->on('tbl_classes')->onDelete('cascade');
        });

        // Mapel kini ditentukan oleh tingkat kelas, bukan checklist per kelas.
        Schema::dropIfExists('tbl_class_subject');

        // Konversi nama kelas lama ("X IPA 1", "XI-A") menjadi tingkat + rombel.
        foreach (DB::table('tbl_classes')->get() as $row) {
            if (preg_match('/^(XII|XI|X)(?![A-Za-z])[\s\-_]*(.*)$/i', trim($row->class_name), $m)) {
                $section = trim($m[2]);
                DB::table('tbl_classes')->where('class_id', $row->class_id)->update([
                    'grade' => strtoupper($m[1]),
                    'section' => $section !== '' ? $section : null,
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('tbl_assignments', function (Blueprint $table) {
            $table->dropForeign(['class_id']);
            $table->dropColumn('class_id');
        });
        Schema::table('tbl_students', fn (Blueprint $t) => $t->dropColumn('status'));
        Schema::table('tbl_subjects', fn (Blueprint $t) => $t->dropColumn('grade'));
        Schema::table('tbl_classes', fn (Blueprint $t) => $t->dropColumn(['grade', 'section']));

        Schema::create('tbl_class_subject', function (Blueprint $table) {
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('subject_id');
            $table->primary(['class_id', 'subject_id']);
            $table->foreign('class_id')->references('class_id')->on('tbl_classes')->onDelete('cascade');
            $table->foreign('subject_id')->references('subject_id')->on('tbl_subjects')->onDelete('cascade');
        });
    }
};
