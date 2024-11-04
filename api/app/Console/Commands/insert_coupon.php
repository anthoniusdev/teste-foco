<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Coupon;

class insert_coupon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:insert_coupon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inserts a first reserve coupon into the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $coupon = new Coupon();
        $coupon->code = 'F1RSTR10';
        $coupon->discount = 10;
        $coupon->active = true;
        $coupon->limit = 100;
        $coupon->used = 0;
        $coupon->validity = '2025-11-03';
        $coupon->save();
    }
}
