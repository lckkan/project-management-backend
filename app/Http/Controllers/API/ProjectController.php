<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $projects = Project::where('user_id', auth()->id())->get();

        return response()->json($projects, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 400);
        }

        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $data['due_date'] = $request->due_date;
        $data['user_id'] = auth()->id();


        //$project = Project::create($request->all());
        $project = Project::create($data);

        return response()->json($project, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $project = Project::with('tasks')->find($id);

        if (!$project) {
            return response()->json([
                'message' => 'Project Not Found'
            ], 404);
        }
        return response()->json($project, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $project = Project::find($id);
        if (!$project) {
            return response()->json([
                'message' => 'Project Not Found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date'

        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 400);
        }

        $project->name = $request->name;
        $project->description = $request->description;
        $project->due_date = $request->due_date;
        $project->user_id = auth()->id();

        $project->save();

        return response()->json($project, 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $project = Project::find($id);
        if (!$project) {
            return response()->json([
                'message' => 'Project Not Found'
            ], 404);
        }

        $project->delete();
        return response()->json([
            'message' => 'Project deleted Successfully'
        ], 201);
    }
}
