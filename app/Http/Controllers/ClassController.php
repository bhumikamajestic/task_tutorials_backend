<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\Enrollment;

class ClassController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | GET ALL CLASSES
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        // fetch all classes with faculty and subject
        $classes = ClassModel::with(['faculty', 'subject'])->get();

        return response()->json([
            'success' => true,
            'message' => 'Classes fetched successfully',
            'data' => $classes
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE NEW CLASS
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'subject_id' => 'required|exists:subjects,id',
            'name' => 'required|string|max:20',
            'class_link' => 'required|string|max:100',
            'class_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $class = ClassModel::create([
            'faculty_id' => $request->faculty_id,
            'subject_id' => $request->subject_id,
            'name' => $request->name,
            'class_link' => $request->class_link,
            'class_date' => $request->class_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Class created successfully',
            'data' => $class
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | GET SINGLE CLASS
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $class = ClassModel::with(['faculty', 'subject'])->find($id);

        if (!$class) {
            return response()->json([
                'success' => false,
                'message' => 'Class not found'
            ], 404);
        }

        if (auth()->user()->role_id == 1) {
            $enrollment = Enrollment::where('user_id', auth()->id())
                ->where('class_id', $class->id)
                ->where('status', 'approved')
                ->first();

            if (!$enrollment) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not enrolled in this class'
                ], 403);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Class fetched successfully',
            'data' => $class
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE CLASS
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $class = ClassModel::find($id);

        if (!$class) {
            return response()->json([
                'success' => false,
                'message' => 'Class not found'
            ], 404);
        }

        $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'subject_id' => 'required|exists:subjects,id',
            'name' => 'required|string|max:20',
            'class_link' => 'required|string|max:100',
            'class_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $class->update([
            'faculty_id' => $request->faculty_id,
            'subject_id' => $request->subject_id,
            'name' => $request->name,
            'class_link' => $request->class_link,
            'class_date' => $request->class_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Class updated successfully',
            'data' => $class
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE CLASS
    |--------------------------------------------------------------------------
    */
   public function destroy($id)
{
    $class = ClassModel::find($id);

    if (!$class) {
        return response()->json([
            'success' => false,
            'message' => 'Class not found'
        ], 404);
    }

    $class->delete();

    return response()->json([
        'success' => true,
        'message' => 'Class deleted successfully'
    ], 200);
}

public function myClasses()
{
    $classes = Enrollment::where(
        'user_id',
        auth()->id()
    )
    ->where(
        'status',
        'approved'
    )
    ->with([
        'class.subject',
        'class.faculty.user'
    ])
    ->get()
    ->pluck('class');

    return response()->json([
        'success' => true,
        'message' => 'My classes fetched successfully',
        'data' => $classes
    ], 200);

}
public function facultyClasses()
{
    $faculty = \App\Models\Faculty::where(
        'user_id',
        auth()->id()
    )->first();

    if (!$faculty) {

        return response()->json([
            'success' => false,
            'message' => 'Faculty profile not found'
        ], 404);
    }

    $classes = ClassModel::where(
        'faculty_id',
        $faculty->id
    )
    ->with([
        'subject',
        'faculty.user'
    ])
    ->get();

    return response()->json([
        'success' => true,
        'message' => 'Faculty classes fetched successfully',
        'data' => $classes
    ], 200);
}
}
