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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('Method');
            $table->float('Value');
            $table->unsignedBigInteger('reserveCode');
            $table->timestamps();

            /**
             * Add a foreign key constraint to the reserveCode column
             * which references the id column on the reserves table.
             */
            $table->foreign('reserveCode')->references('id')->on('reserves');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
