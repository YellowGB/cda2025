<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNeoRequest;
use App\Models\Neo;
use Illuminate\Http\JsonResponse;

class NeoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'neos' => Neo::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNeoRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $neo = Neo::create($validated);

        return response()->json([
            'Message' => "It's all good!",
            'neo' => $neo->fresh(),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Neo $neo): JsonResponse
    {
        return response()->json($neo);
    }
}
