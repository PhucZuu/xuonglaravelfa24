<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['error' => 'Dự án không tồn tại.'], 404);
        }

        $tasks = $project->tasks;

        return response()->json(['tasks' => $tasks]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id)
    {
        $data = $request->validate([
            'task_name'     => 'required|string|max:255',
            'description'   => 'nullable|string',
            'status'        => 'required|string',
        ]);

        $project = Project::find($id);

        if (!$project) {
            return response()->json(['error' => 'Dự án không tồn tại.'], 404);
        }
        try {
            $task = $project->tasks()->create($data);

            return response()->json([
                'message' => 'Nhiệm vụ được tạo thành công.',
                'task' => $task,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Có lỗi xảy ra'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, string $taskId)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['error' => 'Dự án không tồn tại.'], 404);
        }

        $task = $project->tasks()->find($taskId);

        if (!$task) {
            return response()->json(['error' => 'Nhiệm vụ không tồn tại.'], 404);
        }

        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, string $taskId)
    {
        $data = $request->validate([
            'task_name'     => 'required|string|max:255',
            'description'   => 'nullable|string',
            'status'        => 'required|string',
        ]);

        $project = Project::find($id);

        if (!$project) {
            return response()->json(['error' => 'Dự án không tồn tại.'], 404);
        }
        try {
            $task = $project->tasks()->find($taskId);

            if(!$task){
                return response()->json(['error' => 'Nhiệm vụ không tồn tại.'], 404);
            }

            $task->update($data);

            return response()->json([
                'message' => 'Nhiệm vụ được cập nhật thành công.',
                'task' => $task,
            ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Có lỗi xảy ra'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, string $taskId)
    {
        try {
            $project = Project::find($id);
            
            $task = $project->tasks()->find($taskId);
    
            $task->delete();
    
            return response()->json(['message' => 'Nhiệm vụ đã được xóa thành công.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Có lỗi xảy ra'], 500);
        }
    }
}
