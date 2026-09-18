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
            $table->dropUnique(['email']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['name', 'email', 'email_verified_at']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('full_name');
            $table->string('phone')->unique();
            $table->string('role')->default('user');
            $table->foreignId('region_id')->nullable()->constrained()->nullOnDelete();
        });

        Schema::create('otp_codes', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('code');
            $table->timestamp('expires_at');
            $table->timestamps();

            $table->index('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otp_codes');

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['region_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['full_name', 'phone', 'role', 'region_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
        });
    }
};
