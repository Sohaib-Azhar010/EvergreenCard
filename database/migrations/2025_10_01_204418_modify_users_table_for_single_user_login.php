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
        Schema::table('users', function (Blueprint $table) {
            // Drop email column and add username
            $table->dropColumn('email');
            $table->dropColumn('email_verified_at');
            $table->string('username')->unique()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Restore email columns
            $table->string('email')->unique()->after('id');
            $table->timestamp('email_verified_at')->nullable()->after('email');
            $table->dropColumn('username');
        });
    }
};
