<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Enrollment;
use App\Models\Faculty;
use App\Models\ClassModel;

class NoteController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | GET NOTES
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | ADMIN GETS ALL NOTES
        |--------------------------------------------------------------------------
        */

        if (auth()->user()->role_id == 3) {

            $notes = Note::with([

                'class',

                'subject'

            ])->get();

            return response()->json([

                'success' => true,

                'message' => 'All notes fetched successfully',

                'data' => $notes

            ], 200);
        }

        /*
        |--------------------------------------------------------------------------
        | FACULTY GETS OWN CLASS NOTES
        |--------------------------------------------------------------------------
        */

        if (auth()->user()->role_id == 2) {

            $faculty = Faculty::where(

                'user_id',

                auth()->id()

            )->first();

            $class_ids = ClassModel::where(

                'faculty_id',

                $faculty->id

            )->pluck('id');

            $notes = Note::whereIn(

                'class_id',

                $class_ids

            )->with([

                'class',

                'subject'

            ])->get();

            return response()->json([

                'success' => true,

                'message' => 'Faculty notes fetched successfully',

                'data' => $notes

            ], 200);
        }

        /*
        |--------------------------------------------------------------------------
        | STUDENT GETS ENROLLED CLASS NOTES
        |--------------------------------------------------------------------------
        */

        $class_ids = Enrollment::where(

            'user_id',

            auth()->id()

        )->where(

            'status',

            'approved'

        )->pluck('class_id');

        $notes = Note::whereIn(

            'class_id',

            $class_ids

        )->with([

            'class',

            'subject'

        ])->get();

        return response()->json([

            'success' => true,

            'message' => 'Student notes fetched successfully',

            'data' => $notes

        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE NOTE
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

            'subject_id' => 'required|exists:subjects,id',

            'topic' => 'required',

            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx'
        ]);

        /*
        |--------------------------------------------------------------------------
        | ONLY ADMIN AND FACULTY CAN CREATE
        |--------------------------------------------------------------------------
        */

        if (!in_array(auth()->user()->role_id, [2, 3])) {

            return response()->json([

                'success' => false,

                'message' => 'Unauthorized access'

            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | FACULTY CAN ONLY CREATE OWN CLASS NOTES
        |--------------------------------------------------------------------------
        */

        if (auth()->user()->role_id == 2) {

            $faculty = Faculty::where(

                'user_id',

                auth()->id()

            )->first();

            $class = ClassModel::where(

                'id',

                $request->class_id

            )->where(

                'faculty_id',

                $faculty->id

            )->first();

            if (!$class) {

                return response()->json([

                    'success' => false,

                    'message' => 'You can only upload notes for your own classes'

                ], 403);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | STORE FILE
        |--------------------------------------------------------------------------
        */

        $filePath = $request->file('file')

            ->store('notes', 'public');

        /*
        |--------------------------------------------------------------------------
        | CREATE NOTE
        |--------------------------------------------------------------------------
        */

        $note = Note::create([

            'class_id' => $request->class_id,

            'subject_id' => $request->subject_id,

            'topic' => $request->topic,

            'file_url' => $filePath
        ]);

        return response()->json([

            'success' => true,

            'message' => 'Note uploaded successfully',

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
        $note = Note::with([

            'class',

            'subject'

        ])->find($id);

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

        /*
        |--------------------------------------------------------------------------
        | ONLY ADMIN AND FACULTY CAN UPDATE
        |--------------------------------------------------------------------------
        */

        if (!in_array(auth()->user()->role_id, [2, 3])) {

            return response()->json([

                'success' => false,

                'message' => 'Unauthorized access'

            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | FACULTY CAN ONLY UPDATE OWN CLASS NOTES
        |--------------------------------------------------------------------------
        */

        if (auth()->user()->role_id == 2) {

            $faculty = Faculty::where(

                'user_id',

                auth()->id()

            )->first();

            $class = ClassModel::where(

                'id',

                $note->class_id

            )->where(

                'faculty_id',

                $faculty->id

            )->first();

            if (!$class) {

                return response()->json([

                    'success' => false,

                    'message' => 'You can only update your own class notes'

                ], 403);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE FILE IF EXISTS
        |--------------------------------------------------------------------------
        */

        $filePath = $note->file_url;

        if ($request->hasFile('file')) {

            $filePath = $request->file('file')

                ->store('notes', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE NOTE
        |--------------------------------------------------------------------------
        */

        $note->update([

            'class_id' => $request->class_id,

            'subject_id' => $request->subject_id,

            'topic' => $request->topic,

            'file_url' => $filePath
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

        /*
        |--------------------------------------------------------------------------
        | ONLY ADMIN AND FACULTY CAN DELETE
        |--------------------------------------------------------------------------
        */

        if (!in_array(auth()->user()->role_id, [2, 3])) {

            return response()->json([

                'success' => false,

                'message' => 'Unauthorized access'

            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | FACULTY CAN ONLY DELETE OWN CLASS NOTES
        |--------------------------------------------------------------------------
        */

        if (auth()->user()->role_id == 2) {

            $faculty = Faculty::where(

                'user_id',

                auth()->id()

            )->first();

            $class = ClassModel::where(

                'id',

                $note->class_id

            )->where(

                'faculty_id',

                $faculty->id

            )->first();

            if (!$class) {

                return response()->json([

                    'success' => false,

                    'message' => 'You can only delete your own class notes'

                ], 403);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | DELETE NOTE
        |--------------------------------------------------------------------------
        */

        $note->delete();

        return response()->json([

            'success' => true,

            'message' => 'Note deleted successfully'

        ], 200);
    }
    public function classNotes($classId)
{
    $enrollment = Enrollment::where(
        'user_id',
        auth()->id()
    )
    ->where(
        'class_id',
        $classId
    )
    ->where(
        'status',
        'approved'
    )
    ->first();

    if (!$enrollment) {

        return response()->json([

            'success' => false,

            'message' => 'Unauthorized access'

        ], 403);
    }

    $notes = Note::where(
        'class_id',
        $classId
    )
    ->with([
        'class',
        'subject'
    ])
    ->get();

    return response()->json([

        'success' => true,

        'message' => 'Class notes fetched successfully',

        'data' => $notes

    ], 200);
}
}
