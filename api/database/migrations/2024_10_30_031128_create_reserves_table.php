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
        Schema::create('reserves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('roomCode');
            $table->unsignedBigInteger('hotelCode');
            $table->unsignedBigInteger('guestCode');
            $table->date('checkIn');
            $table->date('checkOut');
            $table->float('Total', 10, 2)->default(0.0);
            $table->boolean('isPayed')->default(false);
            $table->timestamps();

            /**
             * Add a foreign key constraint to the roomCode column
             * which references the id column on the rooms table.
             */
            $table->foreign('roomCode')->references('id')->on('rooms');

            /**
             * Add a foreign key constraint to the hotelCode column
             * which references the id column on the hotels table.
             */
            $table->foreign('hotelCode')->references('id')->on('hotels');

            /**
             * Add a foreign key constraint to the guestCode column
             * which references the id column on the guests table.
             */
            $table->foreign('guestCode')->references('id')->on('guests');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserves');
    }
};
