<?php

namespace App\Http\Controllers;

use App\Models\CleaningTask;
use App\Models\Housekeeper;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CleaningTaskController extends Controller
{
    public function index(): View
    {
        $tasks = CleaningTask::with(['room', 'housekeeper'])
            ->orderByRaw("case when status = 'pending' then 1 when status = 'in_progress' then 2 else 3 end")
            ->orderBy('scheduled_for')
            ->paginate(12);

        return view('tasks.index', [
            'tasks' => $tasks,
            'rooms' => Room::orderBy('number')->get(),
            'housekeepers' => Housekeeper::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return redirect()->route('tasks.index');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:2000'],
            'room_id' => ['required', 'exists:rooms,id'],
            'housekeeper_id' => ['nullable', 'exists:housekeepers,id'],
            'priority' => ['required', Rule::in(['low', 'medium', 'high'])],
            'status' => ['required', Rule::in(['pending', 'in_progress', 'done'])],
            'scheduled_for' => ['required', 'date'],
        ]);

        if ($validated['status'] === 'done') {
            $validated['completed_at'] = now();
        }

        CleaningTask::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(string $id)
    {
        return redirect()->route('tasks.index');
    }

    public function edit(CleaningTask $task): View
    {
        return view('tasks.edit', [
            'task' => $task,
            'rooms' => Room::orderBy('number')->get(),
            'housekeepers' => Housekeeper::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, CleaningTask $task): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:2000'],
            'room_id' => ['required', 'exists:rooms,id'],
            'housekeeper_id' => ['nullable', 'exists:housekeepers,id'],
            'priority' => ['required', Rule::in(['low', 'medium', 'high'])],
            'status' => ['required', Rule::in(['pending', 'in_progress', 'done'])],
            'scheduled_for' => ['required', 'date'],
        ]);

        $validated['completed_at'] = $validated['status'] === 'done'
            ? ($task->completed_at ?? now())
            : null;

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(CleaningTask $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted.');
    }
}
