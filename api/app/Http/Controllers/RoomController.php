<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::all();
        if ($rooms->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No rooms found',
                'data' => null
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Rooms retrieved successfully',
            'data' => $rooms
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Name' => 'required|string',
            'hotelCode' => 'required|integer',
        ]);

        $room = Room::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Room created successfully',
            'data' => $room
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $room = Room::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Room retrieved successfully',
            'data' => $room
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'Name' => 'required|string',
            'hotelCode' => 'required|integer',
        ]);

        $room = Room::findOrFail($id);

        $room->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Room updated successfully',
            'data' => $room
        ], 200);
    }

    public function updatePartial(Request $request, int $id)
    {
        $room = Room::findOrFail($id);

        if ($request->has('Name') || $request->has('hotelCode')) {
            $request->validate([
                'Name' => 'string',
                'hotelCode' => 'integer',
            ]);
            $room->update($request->all());            
            return response()->json([
                'status' => 'success',
                'message' => 'Room updated successfully',
                'data' => $room
            ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data to update',
                'data' => null
            ], 400);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        Room::findOrFail($id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Room deleted successfully',
            'data' => null
        ], 200);
    }
}
