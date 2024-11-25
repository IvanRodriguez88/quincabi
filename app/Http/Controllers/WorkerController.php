<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\WorkerRequest;

use App\Models\Worker;
use App\Http\Helpers\Modal;

class WorkerController extends Controller
{
	protected $routeResource = 'workers';
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		$routeResource = $this->routeResource;
		
		$workers = Worker::all();
        $heads = [
            'ID',
            'Name',
            'Hourly Pay',
            'Email',
            'Phone',
			'Actions'
        ];
        return view('workers.index', compact('heads', 'workers', 'routeResource'));
    }

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

	public function destroy(Worker $worker)
	{
		$status = true;
        try {
            $worker->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status]);
	}


	public function getAddEditModal($id = null)
	{
		if ($id !== 'undefined'){
			$worker = Worker::find($id);
			$modal = new Modal($this->routeResource.'Modal', 'Edit Worker', $this->routeResource, $worker);
			return $modal->getModalAddEdit(request()->type, $id);
		}else{
			$modal = new Modal($this->routeResource.'Modal', 'Add Worker', $this->routeResource);
			return $modal->getModalAddEdit(request()->type);
		}

	}
}
