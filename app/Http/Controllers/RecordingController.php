<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recording;
use App\Models\Enrollment;
use App\Models\Faculty;
use App\Models\ClassModel;

class RecordingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | GET RECORDINGS
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | ADMIN GETS ALL RECORDINGS
        |--------------------------------------------------------------------------
        */

        if (auth()->user()->roleId == 3) {

            $recordings = Recording::with('class')->get();

            return response()->json([

                'success' => true,

                'message' => 'All recordings fetched successfully',

                'data' => $recordings

            ], 200);
        }

        /*
        |--------------------------------------------------------------------------
        | FACULTY GETS OWN CLASS RECORDINGS
        |--------------------------------------------------------------------------
        */

        if (auth()->user()->roleId == 2) {

            $classId = $request->class_id;

            $faculty = Faculty::where(

                'userId',

                auth()->id()

            )->first();

            /*
            |--------------------------------------------------------------------------
            | CHECK CLASS OWNERSHIP
            |--------------------------------------------------------------------------
            */

            $class = ClassModel::where(

                'id',

                $classId

            )->where(

                'facultyId',

                $faculty->id

            )->first();

            if (!$class) {

                return response()->json([

                    'success' => false,

                    'message' => 'Unauthorized access'

                ], 403);
            }

            /*
            |--------------------------------------------------------------------------
            | GET RECORDINGS
            |--------------------------------------------------------------------------
            */

            $recordings = Recording::where(

                'class_id',

                $classId

            )->with('class')->get();

            return response()->json([

                'success' => true,

                'message' => 'Faculty recordings fetched successfully',

                'data' => $recordings

            ], 200);
        }

        /*
        |--------------------------------------------------------------------------
        | STUDENT GETS SELECTED CLASS RECORDINGS
        |--------------------------------------------------------------------------
        */

        $classId = $request->class_id;

        /*
        |--------------------------------------------------------------------------
        | CHECK ENROLLMENT
        |--------------------------------------------------------------------------
        */

        $enrollment = Enrollment::where(

            'userId',

            auth()->id()

        )->where(

            'classId',

            $classId

        )->where(

            'status',

            'approved'

        )->first();

        if (!$enrollment) {

            return response()->json([

                'success' => false,

                'message' => 'Unauthorized access'

            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | GET RECORDINGS
        |--------------------------------------------------------------------------
        */

        $recordings = Recording::where(

            'class_id',

            $classId

        )->with('class')->get();

        return response()->json([

            'success' => true,

            'message' => 'Student recordings fetched successfully',

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
        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'class_id' => 'required|exists:classes,id',

            'topic' => 'required',

            'duration' => 'required|integer',

            'video_link' => 'required'
        ]);

        /*
        |--------------------------------------------------------------------------
        | ONLY ADMIN AND FACULTY CAN CREATE
        |--------------------------------------------------------------------------
        */

        if (!in_array(auth()->user()->roleId, [2, 3])) {

            return response()->json([

                'success' => false,

                'message' => 'Unauthorized access'

            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | FACULTY CAN ONLY CREATE OWN CLASS RECORDINGS
        |--------------------------------------------------------------------------
        */

        if (auth()->user()->roleId == 2) {

            $faculty = Faculty::where(

                'userId',

                auth()->id()

            )->first();

            $class = ClassModel::where(

                'id',

                $request->class_id

            )->where(

                'facultyId',

                $faculty->id

            )->first();

            if (!$class) {

                return response()->json([

                    'success' => false,

                    'message' => 'You can only upload recordings for your own classes'

                ], 403);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE RECORDING
        |--------------------------------------------------------------------------
        */

        $recording = Recording::create([

            'class_id' => $request->class_id,

            'topic' => $request->topic,

            'duration' => $request->duration,

            'video_link' => $request->video_link
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
        /*
        |--------------------------------------------------------------------------
        | FIND RECORDING
        |--------------------------------------------------------------------------
        */

        $recording = Recording::with('class')

            ->find($id);

        if (!$recording) {

            return response()->json([

                'success' => false,

                'message' => 'Recording not found'

            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | ADMIN CAN ACCESS ALL
        |--------------------------------------------------------------------------
        */

        if (auth()->user()->roleId == 3) {

            return response()->json([

                'success' => true,

                'message' => 'Recording fetched successfully',

                'data' => $recording

            ], 200);
        }

        /*
        |--------------------------------------------------------------------------
        | FACULTY CAN ACCESS OWN CLASS RECORDINGS
        |--------------------------------------------------------------------------
        */

        if (auth()->user()->roleId == 2) {

            $faculty = Faculty::where(

                'userId',

                auth()->id()

            )->first();

            $class = ClassModel::where(

                'id',

                $recording->class_id

            )->where(

                'facultyId',

                $faculty->id

            )->first();

            if (!$class) {

                return response()->json([

                    'success' => false,

                    'message' => 'Unauthorized access'

                ], 403);
            }

            return response()->json([

                'success' => true,

                'message' => 'Recording fetched successfully',

                'data' => $recording

            ], 200);
        }

        /*
        |--------------------------------------------------------------------------
        | STUDENT CAN ACCESS ONLY ENROLLED CLASS RECORDINGS
        |--------------------------------------------------------------------------
        */

        $enrollment = Enrollment::where(

            'userId',

            auth()->id()

        )->where(

            'classId',

            $recording->class_id

        )->where(

            'status',

            'approved'

        )->first();

        if (!$enrollment) {

            return response()->json([

                'success' => false,

                'message' => 'Unauthorized access'

            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | SUCCESS RESPONSE
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | ONLY ADMIN AND FACULTY CAN UPDATE
        |--------------------------------------------------------------------------
        */

        if (!in_array(auth()->user()->roleId, [2, 3])) {

            return response()->json([

                'success' => false,

                'message' => 'Unauthorized access'

            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | FACULTY CAN ONLY UPDATE OWN CLASS RECORDINGS
        |--------------------------------------------------------------------------
        */

        if (auth()->user()->roleId == 2) {

            $faculty = Faculty::where(

                'userId',

                auth()->id()

            )->first();

            $class = ClassModel::where(

                'id',

                $recording->class_id

            )->where(

                'facultyId',

                $faculty->id

            )->first();

            if (!$class) {

                return response()->json([

                    'success' => false,

                    'message' => 'You can only update your own class recordings'

                ], 403);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE RECORDING
        |--------------------------------------------------------------------------
        */

        $recording->update([

            'class_id' => $request->class_id,

            'topic' => $request->topic,

            'duration' => $request->duration,

            'video_link' => $request->video_link
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

        /*
        |--------------------------------------------------------------------------
        | ONLY ADMIN AND FACULTY CAN DELETE
        |--------------------------------------------------------------------------
        */

        if (!in_array(auth()->user()->roleId, [2, 3])) {

            return response()->json([

                'success' => false,

                'message' => 'Unauthorized access'

            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | FACULTY CAN ONLY DELETE OWN CLASS RECORDINGS
        |--------------------------------------------------------------------------
        */

        if (auth()->user()->roleId == 2) {

            $faculty = Faculty::where(

                'userId',

                auth()->id()

            )->first();

            $class = ClassModel::where(

                'id',

                $recording->class_id

            )->where(

                'facultyId',

                $faculty->id

            )->first();

            if (!$class) {

                return response()->json([

                    'success' => false,

                    'message' => 'You can only delete your own class recordings'

                ], 403);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | DELETE RECORDING
        |--------------------------------------------------------------------------
        */

        $recording->delete();

        return response()->json([

            'success' => true,

            'message' => 'Recording deleted successfully'

        ], 200);
    }
}