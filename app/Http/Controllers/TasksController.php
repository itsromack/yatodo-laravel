<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Task;
use Auth;

class TasksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function fetchAll()
    {
        $tasks = Task::select([
                'id',
                'item',
                'due_date',
                'is_completed',
                'owner_id',
                'created_at'
            ])
            ->orderBy('id', 'DESC')
            ->get();

        if (!empty($tasks))
        {
            return response()->json([
                'success' => true,
                'tasks' => $tasks->toArray()
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    public function fetchOne(Request $request, $id)
    {
        $task = Task::find($id);
        if (!is_null($task))
        {
            return response()->json([
                'success' => true,
                'task' => $task->toArray()
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    public function fetchByOwner(Request $request, $owner_id)
    {
        $tasks = Task::where('owner_id', $owner_id)->get();
        if (!is_null($tasks))
        {
            return response()->json([
                'success' => true,
                'tasks' => $tasks->toArray()
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    public function saveTask(Request $request)
    {
        $item = $request->item;
        $due_date = null;
        if ($request->has('due_date'))
        {
            $due_date = $request->due_date;
        }
        $task = Task::createTask(
                    Auth::id(),
                    $item,
                    $due_date
                );

        if ($task !== false)
        {
            return response()->json([
                'success' => true,
                'task' => $task->toArray()
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    public function updateTask(Request $request)
    {
        $task_id = $request->task_id;
        $item = $request->item;
        $due_date = null;
        $is_completed = false;
        if ($request->has('due_date'))
        {
            $due_date = $request->due_date;
        }
        if ($request->has('is_completed'))
        {
            $is_completed = $request->is_completed;
        }
        $task = Task::updateTask(
            $task_id,
            $item,
            $due_date,
            $is_completed
        );

        if ($task !== false)
        {
            return response()->json([
                'success' => true,
                'task' => $task->toArray()
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    public function completeTask(Request $request)
    {
        $task = Task::find($request->task_id);
        if (!is_null($task))
        {
            $task->setCompleted();
            return response()->json([
                'success' => true,
                'task' => $task->toArray()
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    public function negateCompleteTask(Request $request)
    {
        $task = Task::find($request->task_id);
        if (!is_null($task))
        {
            $task->setNotCompleted();
            return response()->json([
                'success' => true,
                'task_id' => $request->task_id,
                'text' => $task->item
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    public function removeTask(Request $request)
    {
        $task = Task::find($request->task_id);
        if (!is_null($task))
        {
            if ($task->delete())
            {
                return response()->json([
                    'success' => true,
                    'task_id' => $request->task_id
                ]);
            }
        }

        return response()->json([
            'success' => false
        ]);
    }
}
