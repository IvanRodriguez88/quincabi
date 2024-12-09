<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;

use App\Models\Project;
use App\Models\Client;

use App\Models\ProjectPicture;
use App\Models\ProjectTicket;

use App\Http\Helpers\Modal;
use Illuminate\Support\Facades\Storage;

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
			'Initial Date',
			'End Date',
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
			'Cost',
			'Price',
			'Due Date',
			'Using',
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
			'Hourly Pay',
			'Worked Hours',
			'Total',
			'Actions'
        ];
        return view('projects.workers-table', compact('heads', 'project', 'routeResource'));
	}

	private function getPaymentsTable(Project $project = null)
	{
		$routeResource = "project-payments";

        $heads = [
			'ID',
			'Payment Type',
			'Amount',
			'Payment date',
			'Actions'
        ];
        return view('projects.payments-table', compact('heads', 'project', 'routeResource'));
	}

	private function getBillsTable(Project $project = null)
	{
		$routeResource = "bills";

        $heads = [
			'ID',
            'Bill Type',
			'Type',
			'Amount',
			'Date',
			'Description',
			'Actions'
        ];
        return view('projects.bills-table', compact('heads', 'project', 'routeResource'));
	}

	public function edit(Project $project)
	{
        $clients = Client::where("is_active", 1)->get();
		$client = Client::find($project->client_id);
		$clientInfo = $this->getClientInfo($client);

		$invoicesTable = $this->getInvoicesTable($project);
		$workersTable = $this->getWorkersTable($project);
		$paymentsTable = $this->getPaymentsTable($project);
		$billsTable = $this->getBillsTable($project);

        return view('projects.edit', compact("clients", "project", "clientInfo", "invoicesTable", "workersTable", "paymentsTable", "billsTable"));
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

		return redirect()->route('projects.index');
	}

	public function destroy(Project $project)
	{
		$status = true;
        try {
			Storage::disk('public')->deleteDirectory("projects/".$project->id);
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

	public function uploadImage(Request $request, Project $project)
    {
		try {
			$request->validate([
				'image' => 'required|image|mimes:jpg,jpeg,png',
			]);
		
			// Subir la imagen
			$image = $request->file('image');
			$folderPath = 'projects/' . $project->id;
			$path = $image->store($folderPath, 'public');
			$url = Storage::url($path);
		
			// Obtener el nombre del archivo
			$imageName = basename($path);
		
			// Registrar en la base de datos
			$projectPicture = ProjectPicture::create([
				"project_id" => $project->id,
				"path" => $url
			]);

			// Responder con la URL y el nombre del archivo
			return response()->json([
				'url' => $url,
				'name' => $imageName,
				'picture_id' => $projectPicture->id
			]);
		
		} catch (\Exception $e) {
			return response()->json([
				'error' => 'Ocurrió un error al procesar la solicitud.',
			], 500);
		}
    }

	public function deleteImage(Request $request, ProjectPicture $project_picture)
	{
		$filePath = 'projects/'.$project_picture->project->id.'/'. $request->input('name'); // Ruta relativa
		if (Storage::disk('public')->exists($filePath)) {
			Storage::disk('public')->delete($filePath);
			$project_picture->delete();
			return response()->json(['message' => 'Image deleted successfully']);
		}

		return response()->json(['message' => 'Image not found'], 404);
	}

	public function uploadTicket(Request $request, Project $project)
    {
		try {
			$request->validate([
				'image' => 'required|image|mimes:jpg,jpeg,png',
			]);
		
			// Subir la imagen
			$image = $request->file('image');
			$folderPath = 'projects/' . $project->id;
			$path = $image->store($folderPath, 'public');
			$url = Storage::url($path);
		
			// Obtener el nombre del archivo
			$imageName = basename($path);
		
			// Registrar en la base de datos
			$projectTicket = ProjectTicket::create([
				"project_id" => $project->id,
				"path" => $url
			]);

			// Responder con la URL y el nombre del archivo
			return response()->json([
				'url' => $url,
				'name' => $imageName,
				'ticket_id' => $projectTicket->id
			]);
		
		} catch (\Exception $e) {
			return response()->json([
				'error' => 'Ocurrió un error al procesar la solicitud.',
			], 500);
		}
    }

	public function deleteTicket(Request $request, ProjectTicket $project_ticket)
	{
		$filePath = 'projects/'.$project_ticket->project->id.'/'. $request->input('name'); // Ruta relativa
		if (Storage::disk('public')->exists($filePath)) {
			Storage::disk('public')->delete($filePath);
			$project_ticket->delete();
			return response()->json(['message' => 'Ticket deleted successfully']);
		}

		return response()->json(['message' => 'Ticket not found'], 404);
	}

}
