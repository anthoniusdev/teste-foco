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
    /**
     * @OA\Post(
     *     path="/reserve",
     *     summary="Create a new reservation",
     *     description="This endpoint allows the creation of a new reservation.",
     *     operationId="createReservation",
     *     tags={"Reserve"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"CheckIn", "CheckOut", "hotelCode", "roomCode", "dailyValue", "guestName", "guestLastName", "guestPhone"},
     *             type="object",
     *             @OA\Property(property="CheckIn", type="string", format="date", description="Check-in date"),
     *             @OA\Property(property="CheckOut", type="string", format="date", description="Check-out date"),
     *             @OA\Property(property="hotelCode", type="integer", description="Hotel code", example=1),
     *             @OA\Property(property="roomCode", type="integer", description="Room code", example=1),
     *             @OA\Property(property="dailyValue", type="number", format="float", description="Daily value of the room", example=100.00),
     *             @OA\Property(property="guestName", type="string", description="Guest name", example="Anthonius"),
     *             @OA\Property(property="guestLastName", type="string", description="Guest last name", example="Souza"),
     *             @OA\Property(property="guestPhone", type="string", description="Guest phone number", example="557799925474"),
     *             @OA\Property(property="paymentMethod", type="integer", description="Payment method", example=1),
     *             @OA\Property(property="paymentValue", type="number", format="float", description="Payment value", example=100.00)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Reservation created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 description="Status message"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Success message"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 description="Reservation data",
     *                 @OA\Property(property="id", type="integer", description="Reservation ID"),
     *                 @OA\Property(property="CheckIn", type="string", format="date", description="Check-in date"),
     *                 @OA\Property(property="CheckOut", type="string", format="date", description="Check-out date"),
     *                 @OA\Property(property="hotelCode", type="integer", description="Hotel code"),
     *                 @OA\Property(property="roomCode", type="integer", description="Room code"),
     *                 @OA\Property(property="dailyValue", type="number", format="float", description="Daily value of the room"),
     *                 @OA\Property(property="guestCode", type="integer", description="Guest code"),
     *                 @OA\Property(property="Total", type="number", format="float", description="Total value of the reservation"),
     *                 @OA\Property(property="isPayed", type="boolean", description="Payment status"),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     format="date-time",
     *                     description="Creation date"
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     format="date-time",
     *                     description="Update date"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Error message"
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 description="Validation errors",
     *                 @OA\Property(
     *                     property="field",
     *                     type="array",
     *                     description="Error messages",
     *                     @OA\Items(type="string")
     *                 )
     *             )
     *         )
     *     )
     * )
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
