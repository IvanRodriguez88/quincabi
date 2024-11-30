<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ProjectPayment;
use App\Models\ProjectPaymentType;
use App\Models\Project;

use App\Http\Requests\ProjectPaymentRequest;

use App\Http\Helpers\Modal;

class ProjectPaymentController extends Controller
{
    protected $routeResource = 'project_payments';

	public function store(ProjectPaymentRequest $request)
	{
		$status = true;
		$payment = null;

		try {
            $payment = ProjectPayment::create([
				"project_id" => $request->project_id,
				'project_payment_type_id' => $request->project_payment_type_id,
				"amount" => $request->amount,
				"date" => $request->date,
				"created_by" => auth()->id(),
				"updated_by" => auth()->id(),
			]);
			
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		$project = Project::find($payment->project_id);
		$data = [
			$status,
			'payment' => $payment->load(["projectPaymentType"]),
			'project' => $project
		];
		return response()->json($data);
	}

	public function update(ProjectPaymentRequest $request, ProjectPayment $project_payment)
	{

		$status = true;
		try {
            $project_payment->update([
				"project_id" => $request->project_id,
				'project_payment_type_id' => $request->project_payment_type_id,
				"amount" => $request->amount,
				"date" => $request->date,
				"updated_by" => auth()->id(),
				"updated_at" => now()
			]);
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		$project = Project::find($project_payment->project_id);

		$data = [
			$status,
			'payment' => $project_payment->load(["projectPaymentType"]),
			'project' => $project
		];
		return response()->json($data);
	}

	public function destroy(ProjectPayment $project_payment)
	{
		$project = Project::find($project_payment->project_id);
		$status = true;
        try {
            $project_payment->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status, "project" => $project]);
	}

    public function getAddEditModal(Project $project, $id = null)
	{
		if ($id !== 'undefined'){
			$payment = ProjectPayment::find($id);
			$paymentTypes = ProjectPaymentType::all();
			$modal = new Modal($this->routeResource.'Modal', 'Edit Project Payment', $this->routeResource, 
				["project" => $project, "payment" => $payment, "paymentTypes" => $paymentTypes],
				["function" => "savePayment()"]
			);
			return $modal->getModalAddEdit(request()->type, $id);
		}else{
			$paymentTypes = ProjectPaymentType::all();
			$modal = new Modal($this->routeResource.'Modal', 'Add Project Payment', $this->routeResource, 
				["project" => $project, "paymentTypes" => $paymentTypes],
				["function" => "savePayment()"]
			);
			return $modal->getModalAddEdit(request()->type);
		}

	}
}
