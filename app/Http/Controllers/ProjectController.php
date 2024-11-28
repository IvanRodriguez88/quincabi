<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;

use App\Models\Project;
use App\Models\Client;
use App\Http\Helpers\Modal;

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

	private function getInvoicesTable(Project $project = null)
	{
		$routeResource = "project-invoices";

        $heads = [
            'ID',
            'Name',
			'Due Date',
			'Actions'
        ];
        return view('projects.invoices-table', compact('heads', 'project', 'routeResource'));
	}

	private function getWorkersTable(Project $project = null)
	{
		$routeResource = "project-workers";

        $heads = [
            'ID',
            'Name',
			'Actions'
        ];
        return view('projects.workers-table', compact('heads', 'project', 'routeResource'));
	}

	public function edit(Project $project)
	{
        $clients = Client::where("is_active", 1)->get();
		$client = Client::find($project->client_id);
		$clientInfo = $this->getClientInfo($client);

		$invoicesTable = $this->getInvoicesTable($project);
		$workersTable = $this->getWorkersTable($project);

        return view('projects.edit', compact("clients", "project", "clientInfo", "invoicesTable", "workersTable"));
    }

	public function store(ProjectRequest $request)
	{
		$status = true;
		$project = null;
		try {
            $project = Project::create([
				'name' => $request->name,
				'client_id' => $request->client_id,
				'initial_date' => $request->initial_date,
				'end_date' => $request->end_date,
				'cost_real' => $request->cost_real,
				'total_real' => $request->total_real,
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
				'client_id' => $request->client_id,
				'initial_date' => $request->initial_date,
				'end_date' => $request->end_date,
				'cost_real' => $request->cost_real,
				'total_real' => $request->total_real,
				'profit' => $request->total_real - $request->cost_real,
				'description' => $request->description,
				"updated_by" => auth()->id(),
				"updated_at" => now()
			]);

			$project->invoices()->update(["client_id" => $request->client_id]);
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

	public function getClientInfo(Client $client)
	{
		return view("projects.client-info", compact("client"))->render();
	}

	public function getAddEditModal($id = null)
	{
		$data = [
			"clients" => Client::where("is_active", 1)->get()
		];
		//Solo add
		$modal = new Modal($this->routeResource.'Modal', 'Add Project', $this->routeResource, $data);
		return $modal->getModalAddEdit(request()->type);
	}

}
