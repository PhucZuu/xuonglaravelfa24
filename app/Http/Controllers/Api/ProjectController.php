<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();

        return response()->json($projects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'project_name'  => 'required|string|max:255',
            'description'   => 'nullable|string',
            'start_date'    => 'required|date',
        ]);

        try {
            $project = Project::create($data); // Tạo dự án mới

            return response()->json([
                'message' => 'Dự án được tạo',
                'project' => $project,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Có lỗi xảy ra'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::findOrFail($id);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        return response()->json($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'project_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
        ]);

        $project = Project::find($id);

        try {
            $project->update($data);

            return response()->json([
                'message' => 'Dự án được cập nhật',
                'project' => $project,
            ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Có lỗi xảy ra'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::find($id);
        
        try {
            if ($project->tasks()->exists()) {
                $project->tasks()->delete();
            }

            $project->delete();

            return response()->json(['message' => 'Dự án được xóa']);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Có lỗi xảy ra'], 500);
        }
    }
}
