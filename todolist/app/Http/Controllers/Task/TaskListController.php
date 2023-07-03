<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\TaskList;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TaskListController extends Controller
{
    public function view(Request $request): View
    {
        return view('tasklists.index', ['tasklists' => $request->user()->task_lists]);
    }

    public function tasks(Request $request, TaskList $tasklist): View
    {
        if (!Gate::allows('tasklist', $tasklist)) {
            abort(403);
        }

        return view('tasklists.tasks', ['tasklist' => $tasklist]);
    }

    public function create_task(Request $request, TaskList $tasklist): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255']
        ]);

        if (!Gate::allows('tasklist', $tasklist)) {
            abort(403);
        }

        $task = new Task;
        $task->title = $request->title;
        $task->task_list_id = $tasklist->id;
        $task->save();

        return to_route('tasklist-tasks', ['tasklist' => $tasklist->id]);
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

    public function remove(Request $request, TaskList $tasklist): RedirectResponse
    {
        if (!Gate::allows('tasklist', $tasklist)) {
            abort(403);
        }

        $tasklist->delete();

        return to_route('tasklists', ['tasklist' => $tasklist->id]);
    }

    public function remove_task(Request $request, TaskList $tasklist, Task $task): RedirectResponse
    {
        if ($tasklist->id !== $task->task_list_id) {
            abort(404);
        }

        if (!Gate::allows('tasklist', $tasklist)) {
            abort(403);
        }

        $task->delete();

        return to_route('tasklist-tasks', ['tasklist' => $tasklist->id]);
    }
}
