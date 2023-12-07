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
    public function up()
    {
        DB::statement('ALTER TABLE `trips` CHANGE `origin` `pickup_location` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;');
        DB::statement('ALTER TABLE `trips` CHANGE `destination` `destination_location` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;');
        DB::statement('ALTER TABLE `trips` CHANGE `seats_available` `available_seats` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;');

    }    

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::statement('ALTER TABLE `trips` CHANGE `pickup_location` `origin` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;');
        DB::statement('ALTER TABLE `trips` CHANGE `destination_location` `destination` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;');
        DB::statement('ALTER TABLE `trips` CHANGE `available_seats` `seats_available` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;');

    }
    
};
