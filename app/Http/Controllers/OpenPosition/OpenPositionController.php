<?php

namespace App\Http\Controllers\OpenPosition;

use App\Http\Controllers\Controller;
use App\Http\Requests\OpenPositionRequest\storeOpenPositionRequest;
use App\Http\Requests\OpenPositionRequest\updateOpenPositionRequest;
use App\Models\OpenPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OpenPositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    public function fetchPositions(){
        return (OpenPosition::query()
                            ->with(["applicants"])
                            ->orderBy('created_at', 'desc')
                            ->paginate(5));
    }

    public function fetchApplicantsForPosition(OpenPosition $openPosition){
        $applicants = $openPosition->applicants()->get();

        return response()->json([
            'applicants' => $applicants
        ], 201);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeOpenPositionRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = $request->user()->id;

        $position = OpenPosition::create($data);

        return response()->json([
            'message' => 'Position created successfully',
            'position' => $position
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(OpenPosition $openPosition)
    {
        if ($openPosition->user_id != request()->user()->id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        return response()->json([
            'position' => $openPosition
        ], 201);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OpenPosition $openPosition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateOpenPositionRequest $request, OpenPosition $openPosition)
    {
        $data = $request->validated();

        $isUpdated = $openPosition->update($data);
        return response()->json([
            'message' => $isUpdated ? 'Position updated successfully': 'Failed to update position',
            'position' => $openPosition
        ], $isUpdated ? 201:500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OpenPosition $openPosition)
    {
        if (!$openPosition->exists) {
            return response()->json([
                'message' => 'Position not found'
            ], 404);
        }

        if ($openPosition->user_id != request()->user()->id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $openPosition->delete();

        return response()->json([
            'message' => 'Position deleted successfully'
        ], 200);
    }

}
