<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Drop the foreign key first (it depends on the unique index)
            $table->dropForeign(['schedule_id']);
        });

        Schema::table('bookings', function (Blueprint $table) {
            // Now safe to drop the unique index
            $table->dropUnique('bookings_schedule_id_seat_number_unique');
        });

        Schema::table('bookings', function (Blueprint $table) {
            // Re-add the foreign key without the unique constraint
            $table->foreign('schedule_id')->references('id')->on('schedules')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['schedule_id']);
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->unique(['schedule_id', 'seat_number']);
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->foreign('schedule_id')->references('id')->on('schedules')->cascadeOnDelete();
        });
    }
};