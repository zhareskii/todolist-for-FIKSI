<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class TaskController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    public function create()
    {
        return view('tasks.create');
    }

    public function showHome()
    {
        $tasks = Task::where('user_id', Auth::id())->get();
        return view('layout.home', compact('tasks'));
    }

    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'dueDate' => 'required|date',
    ]);

    // Simpan data ke database
    Task::create([
        'title' => $validated['title'],
        'description' => $validated['description'],
        'due_date' => $validated['dueDate'],
    ]);

    return response()->json(['message' => 'Task created successfully!'], 200);
}



    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $task->delete();
        return redirect()->route('layout.home')->with('success', 'Task deleted successfully!');
    }
}
