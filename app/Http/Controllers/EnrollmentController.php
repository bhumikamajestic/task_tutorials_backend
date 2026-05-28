<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Student;

class EnrollmentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | GET ALL ENROLLMENTS
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $enrollments = Enrollment::with([

            'user',

            'class'

        ])->get();

        return response()->json([

            'success' => true,

            'message' => 'Enrollments fetched successfully',

            'data' => $enrollments

        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE ENROLLMENT REQUEST
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | ONLY STUDENTS CAN ENROLL
        |--------------------------------------------------------------------------
        */

        if (auth()->user()->roleId != 1) {

            return response()->json([

                'success' => false,

                'message' => 'Only students can enroll'

            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'classId' => 'required|exists:classes,id',

            'dob' => 'required|date',

            'address' => 'required'
        ]);

        /*
        |--------------------------------------------------------------------------
        | CHECK DUPLICATE ENROLLMENT
        |--------------------------------------------------------------------------
        */

        $alreadyExists = Enrollment::where(

            'userId',

            auth()->id()

        )->where(

            'classId',

            $request->classId

        )->whereIn(

            'status',

            ['pending', 'approved']

        )->first();

        if ($alreadyExists) {

            return response()->json([

                'success' => false,

                'message' => 'Already enrolled or request pending'

            ], 400);
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE ENROLLMENT REQUEST
        |--------------------------------------------------------------------------
        */

        $enrollment = Enrollment::create([

            'userId' => auth()->id(),

            'classId' => $request->classId,

            'dob' => $request->dob,

            'address' => $request->address,

            'status' => 'pending'
        ]);

        return response()->json([

            'success' => true,

            'message' => 'Enrollment request submitted successfully',

            'data' => $enrollment

        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | GET SINGLE ENROLLMENT
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $enrollment = Enrollment::with([

            'user',

            'class'

        ])->find($id);

        if (!$enrollment) {

            return response()->json([

                'success' => false,

                'message' => 'Enrollment not found'

            ], 404);
        }

        return response()->json([

            'success' => true,

            'message' => 'Enrollment fetched successfully',

            'data' => $enrollment

        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE ENROLLMENT STATUS
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        /*
        |--------------------------------------------------------------------------
        | FIND ENROLLMENT
        |--------------------------------------------------------------------------
        */

        $enrollment = Enrollment::find($id);

        if (!$enrollment) {

            return response()->json([

                'success' => false,

                'message' => 'Enrollment not found'

            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'status' => 'required|in:approved,rejected'
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE STATUS
        |--------------------------------------------------------------------------
        */

        $enrollment->update([

            'status' => $request->status
        ]);

        /*
        |--------------------------------------------------------------------------
        | CREATE STUDENT RECORD
        |--------------------------------------------------------------------------
        */

        if ($request->status == 'approved') {

            $student = Student::where(

                'userId',

                $enrollment->userId

            )->first();

            if (!$student) {

                Student::create([

                    'userId' => $enrollment->userId,

                    'dob' => $enrollment->dob,

                    'address' => $enrollment->address
                ]);
            }
        }

        return response()->json([

            'success' => true,

            'message' => 'Enrollment updated successfully',

            'data' => $enrollment

        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE ENROLLMENT
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        /*
        |--------------------------------------------------------------------------
        | FIND ENROLLMENT
        |--------------------------------------------------------------------------
        */

        $enrollment = Enrollment::find($id);

        if (!$enrollment) {

            return response()->json([

                'success' => false,

                'message' => 'Enrollment not found'

            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | DELETE ENROLLMENT
        |--------------------------------------------------------------------------
        */

        $enrollment->delete();

        return response()->json([

            'success' => true,

            'message' => 'Enrollment deleted successfully'

        ], 200);
    }
}