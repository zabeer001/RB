<?php

namespace App\Traits\Projects;

use App\Models\Project;
use Illuminate\Http\Request;

trait ProjectStore
{
    public function projectStore(Request $request)
    {
        try {
            // Validate input
            $this->validateStoreRequest($request);

            // Create and save the project
            $project = $this->createProject($request);

            // Sync employees (many-to-many)
            $this->syncEmployees($project, $request);

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Project created successfully',
                'data' => $project
            ], 201);
        } catch (\Exception $e) {
            // Log the exception
            \Log::error('Failed to create project: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to create project',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function validateStoreRequest(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'deadline' => 'required|date',
            'employees' => 'nullable|array',
            'employees.*' => 'exists:employees,id',
            'tasks' => 'nullable|array',
            'tasks.*.name' => 'required|string|max:255',
            'tasks.*.description' => 'nullable|string',
            'tasks.*.due_date' => 'nullable|date',
        ]);
    }

    private function createProject(Request $request)
    {
        $project = new Project();
        $project->title = $request->title;
        $project->deadline = $request->deadline;
        $project->save();

        return $project;
    }

    private function syncEmployees(Project $project, Request $request)
    {
        if ($request->has('employees')) {
            $project->employees()->sync($request->input('employees'));
        }
    }

}