<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recording;

class RecordingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | GET ALL RECORDINGS
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $recordings = Recording::with('class')->get();

        return response()->json([
            'success' => true,
            'message' => 'Recordings fetched successfully',
            'data' => $recordings
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE RECORDING
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $recording = Recording::create([
            'class_id' => $request->class_id,
            'topic' => $request->topic,
            'duration' => $request->duration,
            'video_link' => $request->video_link,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Recording created successfully',
            'data' => $recording
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | GET SINGLE RECORDING
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $recording = Recording::with('class')->find($id);

        if (!$recording) {
            return response()->json([
                'success' => false,
                'message' => 'Recording not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Recording fetched successfully',
            'data' => $recording
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE RECORDING
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $recording = Recording::find($id);

        if (!$recording) {
            return response()->json([
                'success' => false,
                'message' => 'Recording not found'
            ], 404);
        }

        $recording->update([
            'class_id' => $request->class_id,
            'topic' => $request->topic,
            'duration' => $request->duration,
            'video_link' => $request->video_link,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Recording updated successfully',
            'data' => $recording
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE RECORDING
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $recording = Recording::find($id);

        if (!$recording) {
            return response()->json([
                'success' => false,
                'message' => 'Recording not found'
            ], 404);
        }

        $recording->delete();

        return response()->json([
            'success' => true,
            'message' => 'Recording deleted successfully'
        ], 200);
    }
}