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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('Name');
            $table->unsignedBigInteger('hotelCode');
            $table->timestamps();

            /**
             * Add a foreign key constraint to the hotelCode column
             * which references the id column on the hotels table.
             */
            $table->foreign('hotelCode')->references('id')->on('hotels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
