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
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->foreignId('schedule_id')->constrained()->cascadeOnDelete();
        $table->string('seat_number');
        $table->string('passenger_name');
        $table->string('contact_number');
        $table->enum('booking_status', ['pending', 'confirmed', 'cancelled'])->default('pending');
        $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');
        $table->timestamps();

        $table->unique(['schedule_id', 'seat_number']); // prevents double-booking a seat
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
