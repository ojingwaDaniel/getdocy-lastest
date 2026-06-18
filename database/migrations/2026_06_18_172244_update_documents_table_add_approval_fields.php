<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            // Approval workflow
            $table->enum('status', ['pending', 'approved', 'rejected'])
                  ->default('pending')
                  ->after('download_count');

            $table->foreignId('approved_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete()
                  ->after('status');

            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->text('rejection_reason')->nullable()->after('approved_at');

            // Replace the old 'type' enum with richer categories
            // First drop the old column, then add the new one
            $table->dropColumn('type');
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->enum('category', [
                'handout',
                'past_question',
                'textbook',
                'note',
                'assignment',
                'other'
            ])->after('file_size');
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn(['status', 'approved_by', 'approved_at', 'rejection_reason', 'category']);
            $table->enum('type', ['lecture_note', 'past_question', 'assignment', 'other']);
        });
    }
};