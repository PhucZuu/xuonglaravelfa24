<?php

use App\Models\Student;
use App\Models\Subject;
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
        Schema::create('table_subject_student', function (Blueprint $table) {
            $table->foreignIdFor(Student::class)->constrained();
            $table->foreignIdFor(Subject::class)->constrained();
            $table->primary(['student_id','subject_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_subject_student');
    }
};
