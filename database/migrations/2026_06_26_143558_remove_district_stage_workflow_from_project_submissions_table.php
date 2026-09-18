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
        DB::table('project_submissions')
            ->where('status', 'district_stage')
            ->update([
                'status' => 'region_stage',
                'region_date' => DB::raw('district_date'),
                'region_time' => DB::raw('district_time'),
            ]);

        Schema::table('project_submissions', function (Blueprint $table) {
            $table->dropColumn(['district_date', 'district_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_submissions', function (Blueprint $table) {
            $table->date('district_date')->nullable()->after('rejection_reason');
            $table->string('district_time', 16)->nullable()->after('district_date');
        });
    }
};
