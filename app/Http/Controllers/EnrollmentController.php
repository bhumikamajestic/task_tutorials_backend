<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;

class EnrollmentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | STUDENT ENROLL REQUEST
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
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

        $alreadyExists = Enrollment::where('userId', auth()->id())

            ->where('classId', $request->classId)

            ->first();

        if ($alreadyExists) {

            return response()->json([

                'success' => false,

                'message' => 'Already enrolled or requested'

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

            'message' => 'Enrollment request submitted',

            'data' => $enrollment

        ], 201);
    }
}