<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        //$tasks = Task::all();
        //$tasks = Task::latest()->get();//Extrae las tareas de la ultima a la primera
        $tasks = Task::latest()->paginate(3);//Extrae las tareas de la ultima a la primera (Hace enpaginado al llegar a la cantidad indicada)
        return view('index', ['tasks' => $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        Task::create($request->all());
        return redirect()->route('tasks.index')->with('success', 'La tarea fue agregada exitosamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task): View
    {
        return view('edit', ['task' => $task]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $task->update($request->all());
        return redirect()->route('tasks.index')->with('success', 'La tarea fue actualizada exitosamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'La tarea fue eliminada exitosamente!');
    }
}
