<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Worker;
use App\Http\Helpers\Modal;

class ProjectWorkerController extends Controller
{
	protected $routeResource = 'project_workers';

	public function store(WorkerRequest $request)
	{
		$status = true;
		$worker = null;
		try {
            $worker = Worker::create([
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

		return response()->json([$status, 'worker' => $worker]);
	}

	public function update(WorkerRequest $request, Worker $worker)
	{
		$status = true;
		try {
            $worker->update([
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

		return response()->json([$status, 'worker' => $worker]);
	}

    public function getAddEditModal($id = null)
	{
		if ($id !== 'undefined'){
			$project = Project::find($id);
            $data = [
				"workers" => Worker::where("is_active", 1)->get()
            ];

			$modal = new Modal($this->routeResource.'Modal', 'Edit worker', $this->routeResource, $data, ['size' => 'xl']);
			return $modal->getModalAddEdit(request()->type, $id);
		}else{
			$data = [
				"workers" => Worker::where("is_active", 1)->get()
			];
			$modal = new Modal($this->routeResource.'Modal', 'Add Worker', $this->routeResource, $data);
			return $modal->getModalAddEdit(request()->type);
		}

		
	}

}
