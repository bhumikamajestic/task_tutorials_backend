<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Homework;

class HomeworkController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | GET ALL HOMEWORKS
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $homeworks = Homework::with(['class', 'student'])->get();

        return response()->json([
            'success' => true,
            'message' => 'Homeworks fetched successfully',
            'data' => $homeworks
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE HOMEWORK
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $homework = Homework::create([
            'class_id' => $request->class_id,
            'student_id' => $request->student_id,
            'topic' => $request->topic,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Homework created successfully',
            'data' => $homework
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | GET SINGLE HOMEWORK
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $homework = Homework::with(['class', 'student'])->find($id);

        if (!$homework) {
            return response()->json([
                'success' => false,
                'message' => 'Homework not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Homework fetched successfully',
            'data' => $homework
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE HOMEWORK
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $homework = Homework::find($id);

        if (!$homework) {
            return response()->json([
                'success' => false,
                'message' => 'Homework not found'
            ], 404);
        }

        $homework->update([
            'class_id' => $request->class_id,
            'student_id' => $request->student_id,
            'topic' => $request->topic,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Homework updated successfully',
            'data' => $homework
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE HOMEWORK
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $homework = Homework::find($id);

        if (!$homework) {
            return response()->json([
                'success' => false,
                'message' => 'Homework not found'
            ], 404);
        }

        $homework->delete();

        return response()->json([
            'success' => true,
            'message' => 'Homework deleted successfully'
        ], 200);
    }
}