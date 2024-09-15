<?php

namespace App\Http\Controllers;

use App\Traits\Projects\ProjectStore;
use App\Traits\Projects\ProjectUpdate;
use App\Models\Project;
use App\Models\Task;
use App\Models\Employee;
use App\Models\ToDo;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use ProjectStore;
    // Display a listing of the resource.
    public function index()
    {
        // Return all projects
        $projects = Project::all();
        return $projects;
    }

    // Store a newly created resource in storage.

    //app/Traits/Projects/ProjectStore.php
    public function store(Request $request)
    {
        return $this->projectStore($request);
    }


    // Display the specified resource.
    public function show($id)
    {
        // Find project by ID with its employees and tasks
        $project = Project::with(['employees', 'tasks.todos'])->find($id);
        // Return the project along with employees and tasks
        return $project;
    }

    // Update the specified resource in storage.
    //app/Traits/Projects/ProjectUpdate.php
    use ProjectUpdate;
    public function update(Request $request, $id)
    {
        return $this->projectUpdate($request, $id);
    }


    // Remove the specified resource from storage.
    public function destroy($id)
    {
        // Find the project
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        // Delete the project
        $project->delete();

        return response()->json(['message' => 'Project deleted successfully'], 200);
    }
}
