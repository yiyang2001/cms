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
        Schema::table('trips', function (Blueprint $table) {
            $table->decimal('pricing', 8, 2)->nullable();
            $table->decimal('recommended_pricing', 8, 2)->nullable();
            $table->unsignedBigInteger('vehicle_id')->after('id')->nullable();
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->string('eta')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn('pricing');
            $table->dropColumn('recommended_pricing');
            $table->dropForeign(['vehicle_id']);
            $table->dropColumn('vehicle_id');
            $table->dropColumn('eta');
        });
    }
};
