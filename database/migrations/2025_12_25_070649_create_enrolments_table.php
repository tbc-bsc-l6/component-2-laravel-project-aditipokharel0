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
    Schema::create('enrolments', function (Blueprint $table) {
        $table->id();

        $table->foreignId('module_id')->constrained()->cascadeOnDelete();
        $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();

        $table->date('start_date');
        $table->date('completion_date')->nullable();

        $table->enum('status', ['active', 'completed'])->default('active');
        $table->enum('result', ['PASS', 'FAIL'])->nullable();
        $table->timestamp('result_set_at')->nullable();

        $table->timestamps();

        $table->unique(['module_id', 'student_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrolments');
    }
};
