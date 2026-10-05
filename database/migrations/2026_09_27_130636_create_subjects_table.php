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
    Schema::create('tbl_subjects', function (Blueprint $table) {
        $table->id('subject_id');
        $table->string('subject_code', 10)->unique();
        $table->string('subject_name', 100);
        $table->integer('credits');
        $table->tinyInteger('archived')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
