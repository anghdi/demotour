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
            $table->string('booking_code')->nullable()->unique();
            $table->foreignId('tour_id')->constrained()->restrictOnDelete();
            $table->date('travel_date')->index();
            $table->unsignedTinyInteger('guest_count');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_whatsapp', 30);
            $table->string('customer_country');
            $table->text('special_request')->nullable();
            $table->unsignedBigInteger('subtotal');
            $table->unsignedBigInteger('total');
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->default('UNPAID')->index();
            $table->string('booking_status')->default('PENDING')->index();
            $table->timestamps();
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
