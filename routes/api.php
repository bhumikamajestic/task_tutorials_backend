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

Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth.session.api'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | COMMON AUTH ROUTES
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/me', [AuthController::class, 'user']);

    /*
    |--------------------------------------------------------------------------
    | ENROLLMENT ROUTES
    |--------------------------------------------------------------------------
    */

    Route::middleware(['isStudent'])->group(function () {

        Route::post('/enrollments', [

            EnrollmentController::class,

            'store'

        ]);

        Route::get('/enrollments/{id}', [

            EnrollmentController::class,

            'show'

        ]);
    });

    /*
    |--------------------------------------------------------------------------
    | STUDENT ROUTES
    |--------------------------------------------------------------------------
    */

    Route::middleware([

        'isStudent',

        'hasAccess'

    ])->group(function () {

        /*
        |--------------------------------------------------------------------------
        | NOTES
        |--------------------------------------------------------------------------
        */

        Route::get('/notes', [

            NoteController::class,

            'index'

        ]);

        Route::get('/notes/{id}', [

            NoteController::class,

            'show'

        ]);

        /*
        |--------------------------------------------------------------------------
        | RECORDINGS
        |--------------------------------------------------------------------------
        */

        Route::get('/recordings', [

            RecordingController::class,

            'index'

        ]);

        Route::get('/recordings/{id}', [

            RecordingController::class,

            'show'

        ]);

        /*
        |--------------------------------------------------------------------------
        | ASSIGN HOMEWORKS
        |--------------------------------------------------------------------------
        */

        Route::get('/assign-homeworks', [

            AssignHomeworkController::class,

            'index'

        ]);

        Route::get('/assign-homeworks/{id}', [

            AssignHomeworkController::class,

            'show'

        ]);

        /*
        |--------------------------------------------------------------------------
        | SUBMIT HOMEWORKS
        |--------------------------------------------------------------------------
        */

        Route::get('/submit-homeworks', [

            SubmitHomeworkController::class,

            'index'

        ]);

        Route::post('/submit-homeworks', [

            SubmitHomeworkController::class,

            'store'

        ]);

        /*
        |--------------------------------------------------------------------------
        | CLASSES
        |--------------------------------------------------------------------------
        */

        Route::get('/classes/{id}', [

            ClassController::class,

            'show'

        ]);

        /*
        |--------------------------------------------------------------------------
        | SUBJECTS
        |--------------------------------------------------------------------------
        */

        Route::get('/subjects', [

            SubjectController::class,

            'index'

        ]);

        Route::get('/subjects/{id}', [

            SubjectController::class,

            'show'

        ]);
    });

    /*
    |--------------------------------------------------------------------------
    | FACULTY ROUTES
    |--------------------------------------------------------------------------
    */

    Route::middleware(['isFaculty'])->group(function () {

        /*
        |--------------------------------------------------------------------------
        | NOTES
        |--------------------------------------------------------------------------
        */

        Route::get('/notes', [

            NoteController::class,

            'index'

        ]);

        Route::get('/notes/{id}', [

            NoteController::class,

            'show'

        ]);

        Route::post('/notes', [

            NoteController::class,

            'store'

        ]);

        Route::put('/notes/{id}', [

            NoteController::class,

            'update'

        ]);

        Route::delete('/notes/{id}', [

            NoteController::class,

            'destroy'

        ]);

        /*
        |--------------------------------------------------------------------------
        | RECORDINGS
        |--------------------------------------------------------------------------
        */

        Route::get('/recordings', [

            RecordingController::class,

            'index'

        ]);

        Route::get('/recordings/{id}', [

            RecordingController::class,

            'show'

        ]);

        Route::post('/recordings', [

            RecordingController::class,

            'store'

        ]);

        Route::put('/recordings/{id}', [

            RecordingController::class,

            'update'

        ]);

        Route::delete('/recordings/{id}', [

            RecordingController::class,

            'destroy'

        ]);

        /*
        |--------------------------------------------------------------------------
        | ASSIGN HOMEWORKS
        |--------------------------------------------------------------------------
        */

        Route::get('/assign-homeworks', [

            AssignHomeworkController::class,

            'index'

        ]);

        Route::get('/assign-homeworks/{id}', [

            AssignHomeworkController::class,

            'show'

        ]);

        Route::post('/assign-homeworks', [

            AssignHomeworkController::class,

            'store'

        ]);

        Route::put('/assign-homeworks/{id}', [

            AssignHomeworkController::class,

            'update'

        ]);

        Route::delete('/assign-homeworks/{id}', [

            AssignHomeworkController::class,

            'destroy'

        ]);

        /*
        |--------------------------------------------------------------------------
        | SUBMIT HOMEWORKS
        |--------------------------------------------------------------------------
        */

        Route::get('/submit-homeworks', [

            SubmitHomeworkController::class,

            'index'

        ]);

        Route::put('/submit-homeworks/{id}', [

            SubmitHomeworkController::class,

            'update'

        ]);
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    */

    Route::middleware(['isAdmin'])->group(function () {

        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */

        Route::get('/users', [

            UserController::class,

            'index'

        ]);

        Route::post('/users', [

            UserController::class,

            'store'

        ]);

        Route::get('/users/{id}', [

            UserController::class,

            'show'

        ]);

        Route::put('/users/{id}', [

            UserController::class,

            'update'

        ]);

        Route::delete('/users/{id}', [

            UserController::class,

            'destroy'

        ]);

        /*
        |--------------------------------------------------------------------------
        | STUDENTS
        |--------------------------------------------------------------------------
        */

        Route::get('/students', [

            StudentController::class,

            'index'

        ]);

        Route::post('/students', [

            StudentController::class,

            'store'

        ]);

        Route::put('/students/{id}', [

            StudentController::class,

            'update'

        ]);

        Route::delete('/students/{id}', [

            StudentController::class,

            'destroy'

        ]);

        /*
        |--------------------------------------------------------------------------
        | ENROLLMENTS
        |--------------------------------------------------------------------------
        */

        Route::get('/enrollments', [

            EnrollmentController::class,

            'index'

        ]);

        Route::put('/enrollments/{id}', [

            EnrollmentController::class,

            'update'

        ]);

        Route::delete('/enrollments/{id}', [

            EnrollmentController::class,

            'destroy'

        ]);

        /*
        |--------------------------------------------------------------------------
        | FACULTIES
        |--------------------------------------------------------------------------
        */

        Route::get('/faculties', [

            FacultyController::class,

            'index'

        ]);

        Route::post('/faculties', [

            FacultyController::class,

            'store'

        ]);

        Route::get('/faculties/{id}', [

            FacultyController::class,

            'show'

        ]);

        Route::put('/faculties/{id}', [

            FacultyController::class,

            'update'

        ]);

        Route::delete('/faculties/{id}', [

            FacultyController::class,

            'destroy'

        ]);

        /*
        |--------------------------------------------------------------------------
        | SUBJECTS
        |--------------------------------------------------------------------------
        */

        Route::get('/subjects', [

            SubjectController::class,

            'index'

        ]);

        Route::post('/subjects', [

            SubjectController::class,

            'store'

        ]);

        Route::get('/subjects/{id}', [

            SubjectController::class,

            'show'

        ]);

        Route::put('/subjects/{id}', [

            SubjectController::class,

            'update'

        ]);

        Route::delete('/subjects/{id}', [

            SubjectController::class,

            'destroy'

        ]);

        /*
        |--------------------------------------------------------------------------
        | CLASSES
        |--------------------------------------------------------------------------
        */

        Route::get('/classes', [

            ClassController::class,

            'index'

        ]);

        Route::post('/classes', [

            ClassController::class,

            'store'

        ]);

        Route::get('/classes/{id}', [

            ClassController::class,

            'show'

        ]);

        Route::put('/classes/{id}', [

            ClassController::class,

            'update'

        ]);

        Route::delete('/classes/{id}', [

            ClassController::class,

            'destroy'

        ]);

        /*
        |--------------------------------------------------------------------------
        | NOTES
        |--------------------------------------------------------------------------
        */

        Route::get('/notes', [

            NoteController::class,

            'index'

        ]);

        Route::get('/notes/{id}', [

            NoteController::class,

            'show'

        ]);

        Route::post('/notes', [

            NoteController::class,

            'store'

        ]);

        Route::put('/notes/{id}', [

            NoteController::class,

            'update'

        ]);

        Route::delete('/notes/{id}', [

            NoteController::class,

            'destroy'

        ]);

        /*
        |--------------------------------------------------------------------------
        | RECORDINGS
        |--------------------------------------------------------------------------
        */

        Route::get('/recordings', [

            RecordingController::class,

            'index'

        ]);

        Route::get('/recordings/{id}', [

            RecordingController::class,

            'show'

        ]);

        Route::post('/recordings', [

            RecordingController::class,

            'store'

        ]);

        Route::put('/recordings/{id}', [

            RecordingController::class,

            'update'

        ]);

        Route::delete('/recordings/{id}', [

            RecordingController::class,

            'destroy'

        ]);

        /*
        |--------------------------------------------------------------------------
        | ASSIGN HOMEWORKS
        |--------------------------------------------------------------------------
        */

        Route::get('/assign-homeworks', [

            AssignHomeworkController::class,

            'index'

        ]);

        Route::get('/assign-homeworks/{id}', [

            AssignHomeworkController::class,

            'show'

        ]);

        Route::post('/assign-homeworks', [

            AssignHomeworkController::class,

            'store'

        ]);

        Route::put('/assign-homeworks/{id}', [

            AssignHomeworkController::class,

            'update'

        ]);

        Route::delete('/assign-homeworks/{id}', [

            AssignHomeworkController::class,

            'destroy'

        ]);

        /*
        |--------------------------------------------------------------------------
        | SUBMIT HOMEWORKS
        |--------------------------------------------------------------------------
        */

        Route::get('/submit-homeworks', [

            SubmitHomeworkController::class,

            'index'

        ]);

        Route::put('/submit-homeworks/{id}', [

            SubmitHomeworkController::class,

            'update'

        ]);

        /*
        |--------------------------------------------------------------------------
        | MAS ROLES
        |--------------------------------------------------------------------------
        */

        Route::get('/mas-roles', [

            MasRoleController::class,

            'index'

        ]);

        Route::post('/mas-roles', [

            MasRoleController::class,

            'store'

        ]);

        Route::get('/mas-roles/{id}', [

            MasRoleController::class,

            'show'

        ]);

        Route::put('/mas-roles/{id}', [

            MasRoleController::class,

            'update'

        ]);

        Route::delete('/mas-roles/{id}', [

            MasRoleController::class,

            'destroy'

        ]);
    });

    /*
    |--------------------------------------------------------------------------
    | TASKS
    |--------------------------------------------------------------------------
    */

    Route::apiResource('tasks', TaskController::class);
});