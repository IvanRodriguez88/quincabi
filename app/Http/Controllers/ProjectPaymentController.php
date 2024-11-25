<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ProyectPayment;
use App\Models\ProjectPaymentType;
use App\Models\Invoice;

use App\Http\Requests\ProjectPaymentRequest;

use App\Http\Helpers\Modal;

class ProjectPaymentController extends Controller
{
    protected $routeResource = 'payments';

	public function store(ProjectPaymentRequest $request)
	{
		$status = true;
		$payment = null;
		$invoice = Invoice::find($request->invoice_id);

		try {
            $payment = ProyectPayment::create([
				"invoice_id" => $request->invoice_id,
				'invoice_payment_type_id' => $request->invoice_payment_type_id,
				"amount" => $request->amount,
				"date" => $request->date,
				"created_by" => auth()->id(),
				"updated_by" => auth()->id(),
			]);

			if ($invoice->getTotalPayments() >= $invoice->getTotal()) {
				$invoice->update(["is_paid" => 1]);
			}
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

    public function getAddEditModal(Invoice $invoice, $id = null)
	{
		if ($id !== 'undefined'){
			$payment = ProyectPayment::find($id);
			$paymentTypes = ProjectPaymentType::all();
			$modal = new Modal($this->routeResource.'Modal', 'Edit ProyectPayment', $this->routeResource, ["invoice" => $invoice, "payment" => $payment, "paymentTypes" => $paymentTypes]);
			return $modal->getModalAddEdit(request()->type, $id);
		}else{
			$paymentTypes = ProjectPaymentType::all();
			$modal = new Modal($this->routeResource.'Modal', 'Add ProyectPayment', $this->routeResource, ["invoice" => $invoice, "paymentTypes" => $paymentTypes]);
			return $modal->getModalAddEdit(request()->type);
		}

	}
}
