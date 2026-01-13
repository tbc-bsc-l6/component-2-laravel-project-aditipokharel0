<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enrolments', function (Blueprint $table) {
            if (!Schema::hasColumn('enrolments', 'student_id')) {
                $table->unsignedBigInteger('student_id')->nullable()->after('module_id');
            }

            if (!Schema::hasColumn('enrolments', 'start_date')) {
                $table->date('start_date')->nullable();
            }

            if (!Schema::hasColumn('enrolments', 'completion_date')) {
                $table->date('completion_date')->nullable();
            }

            if (!Schema::hasColumn('enrolments', 'status')) {
                $table->string('status')->default('active');
            }

            if (!Schema::hasColumn('enrolments', 'result')) {
                $table->string('result')->nullable();
            }

            if (!Schema::hasColumn('enrolments', 'result_set_at')) {
                $table->timestamp('result_set_at')->nullable();
            }
        });

        if (Schema::hasColumn('enrolments', 'user_id') && Schema::hasColumn('enrolments', 'student_id')) {
            DB::table('enrolments')
                ->whereNull('student_id')
                ->update(['student_id' => DB::raw('user_id')]);
        }

        try {
            Schema::table('enrolments', function (Blueprint $table) {
                if (Schema::hasColumn('enrolments', 'student_id')) {
                    $table->foreign('student_id')->references('id')->on('users')->cascadeOnDelete();
                }
            });
        } catch (\Throwable $e) {
            // Ignore if FK already exists or cannot be added due to existing constraints
        }
    }

    public function down(): void
    {
        try {
            Schema::table('enrolments', function (Blueprint $table) {
                if (Schema::hasColumn('enrolments', 'student_id')) {
                    $table->dropForeign(['student_id']);
                }
            });
        } catch (\Throwable $e) {}

        Schema::table('enrolments', function (Blueprint $table) {
            if (Schema::hasColumn('enrolments', 'student_id')) $table->dropColumn('student_id');
            if (Schema::hasColumn('enrolments', 'start_date')) $table->dropColumn('start_date');
            if (Schema::hasColumn('enrolments', 'completion_date')) $table->dropColumn('completion_date');
            if (Schema::hasColumn('enrolments', 'status')) $table->dropColumn('status');
            if (Schema::hasColumn('enrolments', 'result')) $table->dropColumn('result');
            if (Schema::hasColumn('enrolments', 'result_set_at')) $table->dropColumn('result_set_at');
        });
    }
};
