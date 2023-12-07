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
        Schema::table('trip_requests', function (Blueprint $table) {
            //
            $table->softDeletes();

            // Add new columns
            $table->string('pickup_location', 255);
            $table->string('destination_location', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trip_requests', function (Blueprint $table) {
            // Remove new columns
            $table->dropColumn(['pickup_location', 'destination_location']);

            // Remove soft deletes
            $table->dropSoftDeletes();
        });
    }
};
