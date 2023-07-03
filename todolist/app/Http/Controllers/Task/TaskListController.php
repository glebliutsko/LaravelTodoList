<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\TaskList;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TaskListController extends Controller
{
    public function view(Request $request): View
    {
        $tasks = TaskList::where('user_id', $request->user()->id)
            ->get();

        return view('tasklists.index', ['tasklists' => $tasks]);
    }

    public function tasks(Request $request, int $tasklist_id): View
    {
        $tasklist = TaskList::with('tasks')
            ->where('id', $tasklist_id)
            ->first();

        if ($tasklist === null) {
            abort(404);
        }

        if (!Gate::allows('tasklist', $tasklist)) {
            abort(403);
        }

        return view('tasklists.tasks', ['tasklist' => $tasklist]);
    }

    public function create_task(Request $request, int $tasklist_id): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255']
        ]);

        $tasklist = TaskList::where('id', $tasklist_id)
            ->first();

        if ($tasklist === null) {
            abort(404);
        }

        if (!Gate::allows('tasklist', $tasklist)) {
            abort(403);
        }

        $task = new Task;
        $task->title = $request->title;
        $task->task_list_id = $tasklist->id;
        $task->save();

        return to_route('tasklist-tasks', ['tasklist' => $tasklist_id]);
    }

    public function create(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255']
        ]);

        $taskList = new TaskList;
        $taskList->title = $request->title;
        $taskList->user_id = $request->user()->id;
        $taskList->save();

        return to_route('tasklists');
    }
}
