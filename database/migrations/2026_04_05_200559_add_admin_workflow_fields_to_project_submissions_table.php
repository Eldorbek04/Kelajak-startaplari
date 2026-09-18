<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('project_submissions', function (Blueprint $table) {
            $table->text('rejection_reason')->nullable()->after('status');
            $table->date('district_date')->nullable()->after('rejection_reason');
            $table->string('district_time', 16)->nullable()->after('district_date');
            $table->date('region_date')->nullable()->after('district_time');
            $table->string('region_time', 16)->nullable()->after('region_date');
        });

        DB::table('project_submissions')->where('status', 'pending')->update(['status' => 'new']);
        DB::table('project_submissions')->where('status', 'district_passed')->update(['status' => 'region_stage']);
        DB::table('project_submissions')->where('status', 'approved')->update(['status' => 'region_stage']);

        Schema::table('project_submissions', function (Blueprint $table) {
            $table->string('status', 32)->default('new')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_submissions', function (Blueprint $table) {
            $table->string('status', 32)->default('pending')->change();
        });

        DB::table('project_submissions')->where('status', 'new')->update(['status' => 'pending']);
        DB::table('project_submissions')->where('status', 'region_stage')->update(['status' => 'district_passed']);

        Schema::table('project_submissions', function (Blueprint $table) {
            $table->dropColumn([
                'rejection_reason',
                'district_date',
                'district_time',
                'region_date',
                'region_time',
            ]);
        });
    }
};
