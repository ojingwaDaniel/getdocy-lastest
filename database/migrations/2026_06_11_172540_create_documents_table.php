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
       Schema::create('documents', function (Blueprint $table) {
                $table->id();

                $table->string('title');
                $table->text('description')->nullable();
                $table->string('file_path'); 
                $table->string('file_type'); 
                $table->unsignedBigInteger('file_size');
                $table->enum('type', ['handout', 'past_question', 'textbook', 'other']);
                $table->integer('download_count')->default(0);
                $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
                $table->foreignId('department_id')->constrained()->onDelete('cascade');
                $table->foreignId('level_id')->constrained()->onDelete('cascade');
                $table->foreignId('course_id')->constrained()->onDelete('cascade');
              
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
