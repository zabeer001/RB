<?php

namespace App\Traits\Projects;

use App\Models\Project;
use App\Models\Task;
use App\Models\ToDo;
use Illuminate\Http\Request;

trait ProjectUpdate
{
    public function projectUpdate(Request $request, $id)
    {
        try {
            // Validate input
            $this->validateUpdateRequest($request);

            // Find and update project details
            $project = Project::findOrFail($id);
            $this->updateProject($project, $request);

            // Update employees (many-to-many)
            $this->updateEmployees($project, $request);

            // Update tasks (one-to-many)
            $this->updateTasks($project, $request);

            return response()->json([
                'success' => true,
                'message' => 'Project updated successfully',
                'data' => $project
            ], 200);
        } catch (\Exception $e) {
            // Log the exception
            \Log::error('Failed to update project: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to update project',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function validateUpdateRequest(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'deadline' => 'required|date',
            'employees' => 'nullable|array',
            'employees.*' => 'exists:employees,id',
            'tasks' => 'nullable|array',
            'tasks.*.id' => 'nullable|exists:tasks,id',
            'tasks.*.name' => 'required|string|max:255',
            'tasks.*.description' => 'nullable|string',
            'tasks.*.due_date' => 'nullable|date',
            'tasks.*.to_dos' => 'nullable|array',
            'tasks.*.to_dos.*.id' => 'nullable|exists:to_dos,id',
            'tasks.*.to_dos.*.title' => 'nullable|string|max:255',
            'tasks.*.to_dos.*.description' => 'nullable|string',
            'tasks.*.to_dos.*.completed' => 'boolean',
        ]);
    }

    private function updateProject(Project $project, Request $request)
    {
        $project->title = $request->title;
        $project->deadline = $request->deadline;
        $project->save();
    }

    private function updateEmployees(Project $project, Request $request)
    {
        if ($request->has('employees')) {
            $project->employees()->sync($request->input('employees'));
        }
    }

    private function updateTasks(Project $project, Request $request)
    {
        if ($request->has('tasks')) {
            foreach ($request->input('tasks') as $taskData) {
                $this->updateOrCreateTask($project, $taskData);
            }
        }
    }

    private function updateOrCreateTask(Project $project, array $taskData)
    {
        if (isset($taskData['id'])) {
            // Update existing task
            $task = Task::findOrFail($taskData['id']);
            $task->update($taskData);
            $this->updateToDos($task, $taskData['to_dos'] ?? []);
        } else {
            // Create new task and associated to_dos
            $newTask = $project->tasks()->create($taskData);
            $this->updateToDos($newTask, $taskData['to_dos'] ?? []);
        }
    }

    private function updateToDos(Task $task, array $toDos)
    {
        // Extract existing to_do IDs
        $existingToDoIds = $task->to_dos->pluck('id')->toArray();

        foreach ($toDos as $toDoData) {
            if (isset($toDoData['id'])) {
                // Update existing to_do
                $toDo = ToDo::findOrFail($toDoData['id']);
                $toDo->update($toDoData);

                // Remove updated to_do ID from existing list
                $existingToDoIds = array_diff($existingToDoIds, [$toDoData['id']]);
            } else {
                // Create new to_do
                $task->to_dos()->create($toDoData);
            }
        }

        // Delete to_dos that were not included in the update request
        if (!empty($existingToDoIds)) {
            ToDo::whereIn('id', $existingToDoIds)->delete();
        }
    }

 
   
}
