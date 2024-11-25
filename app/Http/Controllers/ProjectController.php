<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;

use App\Models\Project;
use App\Models\Client;

class ProjectController extends Controller
{
	protected $routeResource = 'projects';
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		$routeResource = $this->routeResource;
		
		$projects = Project::all();
        $heads = [
            'ID',
            'Name',
			'Client',
			'Cost',
			'Total',
			'Profit',
			'Actions'
        ];
        return view('projects.index', compact('heads', 'projects', 'routeResource'));
    }

	public function create()
	{
        $clients = Client::where("is_active", 1)->get();
        return view('projects.create', compact("clients"));
    }

	public function store(ProjectRequest $request)
	{
		$status = true;
		$project = null;
		try {
            $project = Project::create([
				'name' => $request->name,
				"phone" => $request->phone,
				"hourly_pay" => $request->hourly_pay,
				"email" => $request->email,
				"created_by" => auth()->id(),
				"updated_by" => auth()->id(),
			]);
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status, 'project' => $project]);
	}

	public function update(ProjectRequest $request, Project $project)
	{
		$status = true;
		try {
            $project->update([
				'name' => $request->name,
				"phone" => $request->phone,
				"hourly_pay" => $request->hourly_pay,
				"email" => $request->email,
				"updated_by" => auth()->id(),
				"updated_at" => now()
			]);
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status, 'project' => $project]);
	}

	public function destroy(Project $project)
	{
		$status = true;
        try {
            $project->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status]);
	}

}
