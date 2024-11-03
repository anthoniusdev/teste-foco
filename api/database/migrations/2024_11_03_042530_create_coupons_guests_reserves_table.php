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
        Schema::create('coupons_guests_reserves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('couponCode');
            $table->unsignedBigInteger('guestCode');
            $table->unsignedBigInteger('reserveCode');
            $table->float('ValueWithoutDiscount');
            $table->float('Discount');
            $table->foreign('couponCode')->references('id')->on('coupons');
            $table->foreign('guestCode')->references('id')->on('guests');
            $table->foreign('reserveCode')->references('id')->on('reserves');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons_guests_reserves');
    }
};
