<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     *  @OA\Get(
     *      path="/room",
     *      operationId="getRoomsList",
     *      tags={"Room"},
     *      summary="Get list of rooms",
     *      description="Returns list of rooms",
     *      @OA\Response(
     *          response=200,
     *          description="Rooms retrieved successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(property="message", type="string", example="Rooms retrieved successfully"),
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="Name", type="string", example="Room 1"),
     *                      @OA\Property(property="hotelCode", type="integer", example=1),
     *                      @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
     *                      @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="No rooms found",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="error"),
     *              @OA\Property(property="message", type="string", example="No rooms found"),
     *          )
     *      )
     *  )
     */
    
    public function index()
    {
        $rooms = Room::all();
        if ($rooms->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No rooms found'
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
    /**
     * @OA\Post(
     *      path="/room",
     *      operationId="storeRoom",
     *      tags={"Room"},
     *      summary="Create a new room",
     *      description="Creates a new room with the provided name and hotel code",
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass room data",
     *          @OA\JsonContent(
     *              required={"Name", "hotelCode"},
     *              @OA\Property(property="Name", type="string", example="Room 1"),
     *              @OA\Property(property="hotelCode", type="integer", example=1)
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Room created successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(property="message", type="string", example="Room created successfully"),
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="Name", type="string", example="Room 1"),
     *                  @OA\Property(property="hotelCode", type="integer", example=1),
     *                  @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
     *                  @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00Z")
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="error"),
     *              @OA\Property(property="message", type="string", example="The given data was invalid."),
     *              @OA\Property(property="errors", type="object",
     *                  @OA\Property(property="Name", type="array",
     *                      @OA\Items(type="string", example="The Name field is required.")
     *                  ),
     *                  @OA\Property(property="hotelCode", type="array",
     *                      @OA\Items(type="string", example="The hotelCode field is required.")
     *                  )
     *              )
     *          )
     *      )
     *  )
     */
    public function store(Request $request)
    {
        $request->validate([
            'Name' => 'required|string',
            'hotelCode' => 'required|integer',
        ],
        [
            'Name.required' => 'The Name field is required.',
            'Name.string' => 'The Name field must be a string.',
            'hotelCode.required' => 'The hotelCode field is required.',
            'hotelCode.integer' => 'The hotelCode field must be an integer.'
        ]
    );

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
    /**
     * @OA\Get(
     *      path="/room/{id}",
     *      operationId="getRoomById",
     *      tags={"Room"},
     *      summary="Get room information",
     *      description="Returns room data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Room id",
     *          required=true,  
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Room retrieved successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(property="message", type="string", example="Room retrieved successfully"),
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="Name", type="string", example="Room 1"),
     *                  @OA\Property(property="hotelCode", type="integer", example=1),
     *                  @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
     *                  @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00Z")
     *              )
     *          )   
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Room not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="error"),
     *              @OA\Property(property="message", type="string", example="Room not found"),
     *          )
     *     )
     * )
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
    /**
     * @OA\Put(
     *      path="/room/{id}",
     *      operationId="updateRoom",
     *      tags={"Room"},
     *      summary="Update existing room",
     *      description="Updates an existing room with the provided name and hotel code",
     *      @OA\Parameter(
     *          name="id",
     *          description="Room id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass room data",
     *          @OA\JsonContent( 
     *              required={"Name", "hotelCode"},
     *              @OA\Property(property="Name", type="string", example="Room 1"), 
     *              @OA\Property(property="hotelCode", type="integer", example=1)
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Room updated successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(property="message", type="string", example="Room updated successfully"),
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="Name", type="string", example="Room 1"),
     *                  @OA\Property(property="hotelCode", type="integer", example=1),
     *                  @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
     *                  @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00Z")
     *              )
     *          )
     *      )
     * )
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

    /**
     * Update the specified resource in storage partially.
    */
    /**
     * @OA\Patch(
     *      path="/room/{id}",
     *      operationId="updatePartialRoom",
     *      tags={"Room"},
     *      summary="Update existing room partially",
     *      description="Partially updates an existing room with the provided name and hotel code",
     *      @OA\Parameter(
     *          name="id",
     *          description="Room id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass room data",
     *          @OA\JsonContent(
     *              @OA\Property(property="Name", type="string", example="Room 1"),
     *              @OA\Property(property="hotelCode", type="integer", example=1)
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Room updated successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(property="message", type="string", example="Room updated successfully"),
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="Name", type="string", example="Room 1"),
     *                  @OA\Property(property="hotelCode", type="integer", example=1),
     *                  @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
     *                  @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00Z")
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="No data to update",
     *          @OA\JsonContent()
     *      )
     * )
     */
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
    /**
     * @OA\Delete(
     *      path="/room/{id}",
     *      operationId="deleteRoom",
     *      tags={"Room"}, 
     *      summary="Delete existing room",
     *      description="Deletes an existing room",
     *      @OA\Parameter(
     *          name="id",
     *          description="Room id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Room deleted successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(property="message", type="string", example="Room deleted successfully"),
     *              @OA\Property(property="data", type="object", example=null)
     *          )
     *      )
     * )
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
