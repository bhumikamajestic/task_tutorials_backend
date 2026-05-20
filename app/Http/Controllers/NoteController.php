<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;

class NoteController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | GET ALL NOTES
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $notes = Note::with(['class', 'subject'])->get();

        return response()->json([
            'success' => true,
            'message' => 'Notes fetched successfully',
            'data' => $notes
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE NEW NOTE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $note = Note::create([
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'topic' => $request->topic,
            'file_url' => $request->file_url,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Note created successfully',
            'data' => $note
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | GET SINGLE NOTE
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $note = Note::with(['class', 'subject'])->find($id);

        if (!$note) {
            return response()->json([
                'success' => false,
                'message' => 'Note not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Note fetched successfully',
            'data' => $note
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE NOTE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $note = Note::find($id);

        if (!$note) {
            return response()->json([
                'success' => false,
                'message' => 'Note not found'
            ], 404);
        }

        $note->update([
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'topic' => $request->topic,
            'file_url' => $request->file_url,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Note updated successfully',
            'data' => $note
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE NOTE
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $note = Note::find($id);

        if (!$note) {
            return response()->json([
                'success' => false,
                'message' => 'Note not found'
            ], 404);
        }

        $note->delete();

        return response()->json([
            'success' => true,
            'message' => 'Note deleted successfully'
        ], 200);
    }
}
