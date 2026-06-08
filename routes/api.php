<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\MasRoleController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\RecordingController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\AssignHomeworkController;
use App\Http\Controllers\SubmitHomeworkController;
use App\Http\Controllers\EnrollmentController;

/*
|--------------------------------------------------------------------------
| PUBLIC AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (SESSION AUTH)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth.session.api'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | COMMON AUTH ROUTES
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'user']);
    Route::get('/enrollments/{id}', [EnrollmentController::class, 'show']);

    /*
    |--------------------------------------------------------------------------
    | STUDENT: ENROLLMENT REQUEST FLOW
    | - Student can request enrollment
    | - Student can view their enrollment request by id
    |--------------------------------------------------------------------------
    */

    Route::middleware(['isStudent'])->group(function () {

        // Student can fetch notes for a particular class (you already created classNotes)
        Route::get('/classes/{id}/notes', [NoteController::class, 'classNotes']);

        Route::get('/my-enrollments',    [EnrollmentController::class, 'myEnrollments']);
        Route::post('/enrollments',      [EnrollmentController::class, 'store']);
    });

    /*
    |--------------------------------------------------------------------------
    | STUDENT: AFTER ACCESS GRANTED (hasAccess)
    |--------------------------------------------------------------------------
    */

    Route::middleware(['isStudent', 'hasAccess'])->group(function () {

        /*
        |--------------------------------------------------------------------------
        | CLASSES (Student Dashboard)
        |--------------------------------------------------------------------------
        */

        // Student gets only enrolled+approved classes (your myClasses() uses enrollments)
        Route::get('/my-classes', [ClassController::class, 'myClasses']);

        // Optional: student can open a single class details page
        Route::get('/classes/{id}', [ClassController::class, 'show']);

        /*
        |--------------------------------------------------------------------------
        | NOTES (Student)
        |--------------------------------------------------------------------------
        */

        // Student sees notes for ALL their approved classes (your NoteController@index)
        Route::get('/notes',      [NoteController::class, 'index']);
        Route::get('/notes/{id}', [NoteController::class, 'show']);

        /*
        |--------------------------------------------------------------------------
        | RECORDINGS (Student)  ✅ FIXED (no conflict now)
        |--------------------------------------------------------------------------
        | Student must choose a class first, then fetch recordings of that class only.
        */

        Route::get(
            '/classes/{class_id}/recordings',
            [RecordingController::class, 'studentClassRecordings']
        );

        Route::get(
            '/student/recordings/{id}',
            [RecordingController::class, 'studentShow']
        );

        /*
        |--------------------------------------------------------------------------
        | ASSIGN HOMEWORKS (Student)
        |--------------------------------------------------------------------------
        */

        Route::get('/assign-homeworks',      [AssignHomeworkController::class, 'index']);
        Route::get('/assign-homeworks/{id}', [AssignHomeworkController::class, 'show']);

        /*
        |--------------------------------------------------------------------------
        | SUBMIT HOMEWORKS (Student)
        |--------------------------------------------------------------------------
        */

        Route::get('/submit-homeworks', [SubmitHomeworkController::class, 'index']);
        Route::post('/submit-homeworks',[SubmitHomeworkController::class, 'store']);

        /*
        |--------------------------------------------------------------------------
        | SUBJECTS (Student)
        |--------------------------------------------------------------------------
        */

        Route::get('/subjects',      [SubjectController::class, 'index']);
        Route::get('/subjects/{id}', [SubjectController::class, 'show']);
    });

    /*
    |--------------------------------------------------------------------------
    | FACULTY ROUTES
    |--------------------------------------------------------------------------
    */

    Route::middleware(['isFaculty'])->group(function () {


        //check my classses 

      Route::get(
    '/faculty/my-classes',
    [ClassController::class, 'facultyClasses']
);
        /*
        |--------------------------------------------------------------------------
        | RECORDINGS (Faculty) ✅ FIXED (no conflict now)
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/faculty/classes/{class_id}/recordings',
            [RecordingController::class, 'facultyClassRecordings']
        );

        Route::post(
            '/faculty/classes/{class_id}/recordings',
            [RecordingController::class, 'facultyStoreInClass']
        );

        Route::get(
            '/faculty/recordings/{id}',
            [RecordingController::class, 'facultyShow'] // make sure this method exists
        );

        Route::put(
            '/faculty/recordings/{id}',
            [RecordingController::class, 'facultyUpdate']
        );

        Route::delete(
            '/faculty/recordings/{id}',
            [RecordingController::class, 'facultyDestroy']
        );

        /*
        |--------------------------------------------------------------------------
        | NOTES (Faculty)
        |--------------------------------------------------------------------------
        */

        Route::get('/notes',        [NoteController::class, 'index']);
        Route::get('/notes/{id}',   [NoteController::class, 'show']);
        Route::post('/notes',       [NoteController::class, 'store']);
        Route::put('/notes/{id}',   [NoteController::class, 'update']);
        Route::delete('/notes/{id}',[NoteController::class, 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | ASSIGN HOMEWORKS (Faculty)
        |--------------------------------------------------------------------------
        */

        Route::get('/assign-homeworks',       [AssignHomeworkController::class, 'index']);
        Route::get('/assign-homeworks/{id}',  [AssignHomeworkController::class, 'show']);
        Route::post('/assign-homeworks',      [AssignHomeworkController::class, 'store']);
        Route::put('/assign-homeworks/{id}',  [AssignHomeworkController::class, 'update']);
        Route::delete('/assign-homeworks/{id}',[AssignHomeworkController::class, 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | SUBMIT HOMEWORKS (Faculty)
        |--------------------------------------------------------------------------
        */

        Route::get('/submit-homeworks',      [SubmitHomeworkController::class, 'index']);
        Route::put('/submit-homeworks/{id}', [SubmitHomeworkController::class, 'update']);
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    */

    Route::middleware(['isAdmin'])->group(function () {

        /*
        |--------------------------------------------------------------------------
        | RECORDINGS (Admin) ✅ FIXED (no conflict now)
        |--------------------------------------------------------------------------
        */

        Route::get('/admin/recordings',        [RecordingController::class, 'adminIndex']);
        Route::get('/admin/recordings/{id}',   [RecordingController::class, 'adminShow']);
        Route::post('/admin/recordings',       [RecordingController::class, 'adminStore']);
        Route::put('/admin/recordings/{id}',   [RecordingController::class, 'adminUpdate']);
        Route::delete('/admin/recordings/{id}',[RecordingController::class, 'adminDestroy']);

        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */

        Route::get('/users',        [UserController::class, 'index']);
        Route::post('/users',       [UserController::class, 'store']);
        Route::get('/users/{id}',   [UserController::class, 'show']);
        Route::put('/users/{id}',   [UserController::class, 'update']);
        Route::delete('/users/{id}',[UserController::class, 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | STUDENTS
        |--------------------------------------------------------------------------
        */

        Route::get('/students',         [StudentController::class, 'index']);
        Route::post('/students',        [StudentController::class, 'store']);
        Route::put('/students/{id}',    [StudentController::class, 'update']);
        Route::delete('/students/{id}', [StudentController::class, 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | ENROLLMENTS (Admin approves/rejects)
        |--------------------------------------------------------------------------
        */

        Route::get('/enrollments',          [EnrollmentController::class, 'index']);
        Route::put('/enrollments/{id}',     [EnrollmentController::class, 'update']);
        Route::delete('/enrollments/{id}',  [EnrollmentController::class, 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | FACULTIES
        |--------------------------------------------------------------------------
        */

        Route::get('/faculties',         [FacultyController::class, 'index']);
        Route::post('/faculties',        [FacultyController::class, 'store']);
        Route::get('/faculties/{id}',    [FacultyController::class, 'show']);
        Route::put('/faculties/{id}',    [FacultyController::class, 'update']);
        Route::delete('/faculties/{id}', [FacultyController::class, 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | SUBJECTS
        |--------------------------------------------------------------------------
        */

        Route::get('/subjects',         [SubjectController::class, 'index']);
        Route::post('/subjects',        [SubjectController::class, 'store']);
        Route::get('/subjects/{id}',    [SubjectController::class, 'show']);
        Route::put('/subjects/{id}',    [SubjectController::class, 'update']);
        Route::delete('/subjects/{id}', [SubjectController::class, 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | CLASSES
        |--------------------------------------------------------------------------
        */

        Route::get('/classes',         [ClassController::class, 'index']);
        Route::post('/classes',        [ClassController::class, 'store']);
        Route::get('/classes/{id}',    [ClassController::class, 'show']);
        Route::put('/classes/{id}',    [ClassController::class, 'update']);
        Route::delete('/classes/{id}', [ClassController::class, 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | NOTES (Admin)
        |--------------------------------------------------------------------------
        */

        Route::get('/notes',          [NoteController::class, 'index']);
        Route::get('/notes/{id}',     [NoteController::class, 'show']);
        Route::post('/notes',         [NoteController::class, 'store']);
        Route::put('/notes/{id}',     [NoteController::class, 'update']);
        Route::delete('/notes/{id}',  [NoteController::class, 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | ASSIGN HOMEWORKS (Admin)
        |--------------------------------------------------------------------------
        */

        Route::get('/assign-homeworks',        [AssignHomeworkController::class, 'index']);
        Route::get('/assign-homeworks/{id}',   [AssignHomeworkController::class, 'show']);
        Route::post('/assign-homeworks',       [AssignHomeworkController::class, 'store']);
        Route::put('/assign-homeworks/{id}',   [AssignHomeworkController::class, 'update']);
        Route::delete('/assign-homeworks/{id}',[AssignHomeworkController::class, 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | SUBMIT HOMEWORKS (Admin can review/update if you want)
        |--------------------------------------------------------------------------
        */

        Route::get('/submit-homeworks',      [SubmitHomeworkController::class, 'index']);
        Route::put('/submit-homeworks/{id}', [SubmitHomeworkController::class, 'update']);

        /*
        |--------------------------------------------------------------------------
        | MAS ROLES
        |--------------------------------------------------------------------------
        */

        Route::get('/mas-roles',         [MasRoleController::class, 'index']);
        Route::post('/mas-roles',        [MasRoleController::class, 'store']);
        Route::get('/mas-roles/{id}',    [MasRoleController::class, 'show']);
        Route::put('/mas-roles/{id}',    [MasRoleController::class, 'update']);
        Route::delete('/mas-roles/{id}', [MasRoleController::class, 'destroy']);
    });

    /*
    |--------------------------------------------------------------------------
    | TASKS (Keep as is)
    |--------------------------------------------------------------------------
    */

    Route::apiResource('tasks', TaskController::class);
});
