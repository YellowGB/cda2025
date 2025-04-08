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
    public function store(StoreNeoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $neo): JsonResponse
    {
        return response()->json([Neo::findOrFail($neo)]);
    }
}
