<?php

namespace App\Http\Controllers;

use App\Models\Daily;
use App\Models\Guest;
use App\Models\Payment;
use App\Models\Reserve;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReserveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'CheckIn' => 'required|date',
            'CheckOut' => 'required|date',
            'hotelCode' => 'required|integer',
            'roomCode' => 'required|integer',
            'dailyValue' => 'required|numeric',
            'guestName' => 'required|string',
            'guestLastName' => 'required|string',
            'guestPhone' => 'required|string',
            'paymentMethod' => 'integer',
            'paymentValue' => 'numeric'
        ]);

        $guest = new Guest();
        if (!DB::table('guests')->where('Phone', $request['guestPhone'])->exists()) {
            $guest->Name = $request['guestName'];
            $guest->Lastname = $request['guestLastName'];
            $guest->Phone = $request['guestPhone'];
            $guest->save();
        } else {
            $guest = Guest::where('Phone', $request['guestPhone'])->first();
        }

        $checkIn = Carbon::parse($request->CheckIn);
        $checkOut = Carbon::parse($request->CheckOut);
        $days = $checkIn->diffInDays($checkOut);
        $valueTotal = $request->dailyValue * $days;

        $request->merge([
            'guestCode' => $guest->id,
            'Total' => $valueTotal
        ]);
        if ($request->has('paymentMethod')) {
            $request->merge(['isPayed' => true]);
        } else {
            $request->merge(['isPayed' => false]);
        }
        $reserve = Reserve::create($request->except(['dailyValue', 'guestName', 'guestLastName', 'guestPhone']));


        for ($i = 0; $i < $days; $i++) {
            $daily = new Daily();
            $daily->Date = $checkIn->addDays($i);
            $daily->Value = $request->dailyValue;
            $daily->reserveCode = $reserve->id;
            $daily->save();
        }

        if ($request->has('paymentMethod')) {
            $payment = new Payment();
            $payment->Value = $valueTotal;
            $payment->Method = $request->paymentMethod;
            $payment->reserveCode = $reserve->id;
            $payment->save();
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Reserve created successfully',
            'data' => $reserve
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Reserve $reserve)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reserve $reserve)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reserve $reserve)
    {
        //
    }
}
