<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomRequest;
use App\Models\Room;
use Illuminate\Http\JsonResponse;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'rooms' => Room::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $room = Room::create($validated);

        return response()->json([
            'message' => 'Room created successfully',
            'room' => $room,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        return response()->json(Room::findOrFail($id));
    }
}
