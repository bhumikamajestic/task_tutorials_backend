<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    // GET all tasks
    public function index()
    {
        return Task::all();
    }

    // POST create task
    public function store(Request $request)
    {
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => false
        ]);

        return response()->json($task, 201);
    }
}