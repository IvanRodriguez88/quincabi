<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ProjectSupplier;
use App\Models\Supplier;
use App\Models\Project;

use App\Http\Requests\ProjectSupplierRequest;

use App\Http\Helpers\Modal;

class ProjectSupplierController extends Controller
{
    protected $routeResource = 'project_suppliers';

	public function store(ProjectSupplierRequest $request)
	{
		$status = true;
		$supplier = null;

		try {
            $supplier = ProjectSupplier::create([
				"project_id" => $request->project_id,
				'supplier_id' => $request->supplier_id,
				"amount" => $request->amount,
				"created_by" => auth()->id(),
				"updated_by" => auth()->id(),
			]);
			
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		$project = Project::find($supplier->project_id);
		$data = [
			$status,
			'supplier' => $supplier->load(["supplier"]),
			'project' => $project
		];
		return response()->json($data);
	}

	public function update(ProjectSupplierRequest $request, ProjectSupplier $project_supplier)
	{

		$status = true;
		try {
            $project_supplier->update([
				"project_id" => $request->project_id,
				'supplier_id' => $request->supplier_id,
				"amount" => $request->amount,
				"updated_by" => auth()->id(),
				"updated_at" => now()
			]);
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		$project = Project::find($project_supplier->project_id);

		$data = [
			$status,
			'supplier' => $project_supplier->load(["supplier"]),
			'project' => $project
		];
		return response()->json($data);
	}

	public function destroy(ProjectSupplier $project_supplier)
	{
		$project = Project::find($project_supplier->project_id);
		$status = true;
        try {
            $project_supplier->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status, "project" => $project]);
	}

    public function getAddEditModal(Project $project, $id = null)
	{
		if ($id !== 'undefined'){
			$project_supplier = ProjectSupplier::find($id);
			$suppliers = Supplier::where("is_active", 1)->get();
			$modal = new Modal($this->routeResource.'Modal', 'Edit Project Supplier', $this->routeResource, 
				["project" => $project, "project_supplier" => $project_supplier, "suppliers" => $suppliers],
				["function" => "saveSupplier()"]
			);
			return $modal->getModalAddEdit(request()->type, $id);
		}else{
			$suppliers = Supplier::where("is_active", 1)->get();
			$modal = new Modal($this->routeResource.'Modal', 'Add Project Supplier', $this->routeResource, 
				["project" => $project, "suppliers" => $suppliers],
				["function" => "saveSupplier()"]
			);
			return $modal->getModalAddEdit(request()->type);
		}

	}
}
