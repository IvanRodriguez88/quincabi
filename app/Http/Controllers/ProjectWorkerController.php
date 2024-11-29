<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProjectWorkerRequest;

use App\Models\ProjectWorker;
use App\Models\Project;
use App\Models\Worker;

use App\Http\Helpers\Modal;

class ProjectWorkerController extends Controller
{
	protected $routeResource = 'project_workers';

	public function store(ProjectWorkerRequest $request)
	{
		$status = true;
		try {
			$project_worker = ProjectWorker::create([
				"project_id" => $request->project_id,
				"worker_id" => $request->worker_id,
				"hourly_pay" => $request->hourly_pay,
				"worked_hours" => $request->worked_hours,
			]);
			$project_worker->load('worker');

        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status, 'project_worker' => $project_worker]);
	}

	public function update(ProjectWorkerRequest $request, ProjectWorker $project_worker)
	{
		$status = true;
		try {
            $project_worker->update([
				"worker_id" => $request->worker_id,
				"hourly_pay" => $request->hourly_pay,
				"worked_hours" => $request->worked_hours,
			]);
			$project_worker->load('worker');
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }
		return response()->json([$status, 'project_worker' => $project_worker]);
	}

	public function destroy(ProjectWorker $project_worker)
	{
		$status = true;
        try {
            $project_worker->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status]);
	}

    public function getAddEditModal(Project $project, $id = null)
	{
		if ($id !== 'undefined'){
			$project_worker = ProjectWorker::find($id);
            $data = [
				"workers" => Worker::where("is_active", 1)->get(),
				"project" => $project,
				"project_worker" => $project_worker
            ];
			$modal = new Modal($this->routeResource.'Modal', 'Edit worker', $this->routeResource, $data);
			return $modal->getModalAddEdit(request()->type, $id);
		}else{
			$data = [
				"workers" => Worker::where("is_active", 1)->get(),
				"project" => $project
			];
			$modal = new Modal($this->routeResource.'Modal', 'Add Worker', $this->routeResource, $data);
			return $modal->getModalAddEdit(request()->type);
		}

		
	}

}
