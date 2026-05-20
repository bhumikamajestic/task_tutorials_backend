<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\RecordingController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MasRoleController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\NoteController;

Route::get('/notes', [NoteController::class, 'index']);

Route::post('/notes', [NoteController::class, 'store']);

Route::get('/notes/{id}', [NoteController::class, 'show']);

Route::put('/notes/{id}', [NoteController::class, 'update']);

Route::delete('/notes/{id}', [NoteController::class, 'destroy']);

Route::get('/subjects', [SubjectController::class, 'index']);

Route::post('/subjects', [SubjectController::class, 'store']);

Route::get('/subjects/{id}', [SubjectController::class, 'show']);

Route::put('/subjects/{id}', [SubjectController::class, 'update']);

Route::delete('/subjects/{id}', [SubjectController::class, 'destroy']);

Route::get('/faculties', [FacultyController::class, 'index']);

Route::post('/faculties', [FacultyController::class, 'store']);

Route::get('/faculties/{id}', [FacultyController::class, 'show']);

Route::put('/faculties/{id}', [FacultyController::class, 'update']);

Route::delete('/faculties/{id}', [FacultyController::class, 'destroy']);

Route::get('/mas-roles', [MasRoleController::class, 'index']);

Route::post('/mas-roles', [MasRoleController::class, 'store']);

Route::get('/mas-roles/{id}', [MasRoleController::class, 'show']);

Route::put('/mas-roles/{id}', [MasRoleController::class, 'update']);

Route::delete('/mas-roles/{id}', [MasRoleController::class, 'destroy']);

Route::get('/users', [UserController::class, 'index']);

Route::post('/users', [UserController::class, 'store']);

Route::get('/users/{id}', [UserController::class, 'show']);

Route::put('/users/{id}', [UserController::class, 'update']);

Route::delete('/users/{id}', [UserController::class, 'destroy']);

Route::get('/homeworks', [HomeworkController::class, 'index']);

Route::post('/homeworks', [HomeworkController::class, 'store']);

Route::get('/homeworks/{id}', [HomeworkController::class, 'show']);

Route::put('/homeworks/{id}', [HomeworkController::class, 'update']);

Route::delete('/homeworks/{id}', [HomeworkController::class, 'destroy']);

Route::get('/recordings', [RecordingController::class, 'index']);

Route::post('/recordings', [RecordingController::class, 'store']);

Route::get('/recordings/{id}', [RecordingController::class, 'show']);

Route::put('/recordings/{id}', [RecordingController::class, 'update']);

Route::delete('/recordings/{id}', [RecordingController::class, 'destroy']);

Route::get('/classes', [ClassController::class, 'index']);

Route::post('/classes', [ClassController::class, 'store']);

Route::get('/classes/{id}', [ClassController::class, 'show']);

Route::put('/classes/{id}', [ClassController::class, 'update']);

Route::delete('/classes/{id}', [ClassController::class, 'destroy']);

Route::get('/students', [StudentController::class, 'index']);

Route::post('/students', [StudentController::class, 'store']);

Route::put('/students/{id}', [StudentController::class, 'update']);

Route::delete('/students/{id}', [StudentController::class, 'destroy']);

Route::apiResource('tasks', TaskController::class);




