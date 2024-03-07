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
        Schema::table('quiz_user', function (Blueprint $table) {
            $table->after('is_completed', function (Blueprint $table) {
                $table->boolean('is_attempted')->default(false);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quiz_user', function (Blueprint $table) {
            $table->dropColumn('is_attempted');
        });
    }
};
