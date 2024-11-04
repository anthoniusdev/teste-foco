<?php

namespace App\Console\Commands;

use App\Models\Daily;
use App\Models\Guest;
use App\Models\Hotel;
use App\Models\Payment;
use App\Models\Reserve;
use App\Models\Room;
use Illuminate\Console\Command;

class recover_data_xml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:recover_data_xml';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /**
         * First, this code snippet sets the path to the xml files.
         */
        $url = '../xml';

        /**
         * Then, it loads the xml files.
         */
        $xml_hotels = simplexml_load_file("{$url}/hotels.xml");
        $xml_reserves = simplexml_load_file("{$url}/reserves.xml");
        $xml_rooms = simplexml_load_file("{$url}/rooms.xml");

        /**
         * After that, it iterates over the xml files and saves the data in the database.
         */
        foreach ($xml_hotels->Hotel as $hotel) {
            $hotel_instance = new Hotel();
            $hotel_instance->Name = $hotel->Name;
            $hotel_instance->save();
        }

        foreach ($xml_rooms->Room as $room) {
            $room_instance = new Room();
            $room_instance->Name = $room->Name;
            $room_instance->hotelCode = $room["hotelCode"];
            $room_instance->save();
        }

        foreach ($xml_reserves->Reserve as $reserve) {

            /**
             * This code snippet creates a new instance of the Reserve model.
             */
            $reserve_instance = new Reserve();

            /**
             * This code snippet creates a new instance of the Guest model and saves the data in the database.
             */
            foreach ($reserve->Guests->Guest as $guest) {
                $guest_instance = new Guest();
                $guest_instance->Name = $guest->Name;
                $guest_instance->LastName = $guest->LastName;
                $guest_instance->Phone = $guest->Phone;
                $guest_instance->save();
                $reserve_instance->guestCode = $guest_instance->id;
            }

            /**
             * This code snippet saves the instance of the Reserve model in the database.
             */
            $reserve_instance->roomCode = $reserve["roomCode"];
            $reserve_instance->hotelCode = $reserve["hotelCode"];
            $reserve_instance->CheckIn = $reserve->CheckIn;
            $reserve_instance->CheckOut = $reserve->CheckOut;
            $reserve_instance->Total = $reserve->Total;
            $reserve_instance->save();

            /**
             * This code snippet creates a new instance of the Payment model and saves the data in the database, if it exists.
             */
            if (!is_null($reserve->Payments->Payment)) {
                foreach ($reserve->Payments->Payment as $payment) {
                    $payment_instance = new Payment();
                    $payment_instance->reserveCode = $reserve_instance->id;
                    $payment_instance->Method = $payment->Method;
                    $payment_instance->Value = $payment->Value;
                    $payment_instance->save();
                }
            }

            /**
             * This code snippet creates a new instance of the Daily model and saves the data in the database.
             */
            foreach ($reserve->Dailies->Daily as $daily) {
                $daily_instance = new Daily();
                $daily_instance->reserveCode = $reserve_instance->id;
                $daily_instance->Date = $daily->Date;
                $daily_instance->Value = $daily->Value;
                $daily_instance->save();
            }
        }
    }
}
