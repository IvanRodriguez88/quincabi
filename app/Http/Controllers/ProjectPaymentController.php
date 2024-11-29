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

		return response()->json([$status, 'payment' => $payment->load(["projectPaymentType"])]);
	}

	public function update(ProjectPaymentRequest $request, ProyectPayment $payment)
	{
		$status = true;
		$invoice = Invoice::find($request->invoice_id);
		try {
            $payment->update([
				"invoice_id" => $request->invoice_id,
				'invoice_payment_type_id' => $request->invoice_payment_type_id,
				"amount" => $request->amount,
				"date" => $request->date,
				"updated_by" => auth()->id(),
				"updated_at" => now()
			]);
			if ($invoice->getTotalPayments() >= $invoice->getTotal()) {
				$invoice->update(["is_paid" => 1]);
			}
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status, 'payment' => $payment->load(["projectPaymentType"])]);
	}

	public function destroy(ProyectPayment $payment)
	{
		$status = true;
        try {
            $payment->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status]);
	}

    public function getAddEditModal(Project $project, $id = null)
	{
		if ($id !== 'undefined'){
			$payment = ProyectPayment::find($id);
			$paymentTypes = ProjectPaymentType::all();
			$modal = new Modal($this->routeResource.'Modal', 'Edit ProyectPayment', $this->routeResource, 
				["project" => $project, "payment" => $payment, "paymentTypes" => $paymentTypes],
				["function" => "savePayment()"]
			);
			return $modal->getModalAddEdit(request()->type, $id);
		}else{
			$paymentTypes = ProjectPaymentType::all();
			$modal = new Modal($this->routeResource.'Modal', 'Add ProyectPayment', $this->routeResource, 
				["project" => $project, "paymentTypes" => $paymentTypes],
				["function" => "savePayment()"]
			);
			return $modal->getModalAddEdit(request()->type);
		}

	}
}
