<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /**
         * Create a trigger to verify if the payment was made.
         */
        DB::statement('
            CREATE TRIGGER trigger_verify_payment
            BEFORE INSERT ON payments
            FOR EACH ROW
            BEGIN
                DECLARE reserveValue FLOAT;
                DECLARE paymentTotal FLOAT;

                SELECT Total INTO reserveValue FROM reserves WHERE id = NEW.reserveCode;
                SELECT SUM(Value) INTO paymentTotal FROM payments WHERE reserveCode = NEW.reserveCode;

                IF reserveValue = paymentTotal THEN
                    UPDATE reserves SET isPayed = TRUE WHERE id = NEW.reserveCode; 
                END IF;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP TRIGGER IF EXISTS trigger_verify_payment');
    }
};
