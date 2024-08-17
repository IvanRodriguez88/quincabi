<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\InvoicePayment;
use App\Models\InvoicePaymentType;
use App\Models\Invoice;

use App\Http\Requests\InvoicePaymentRequest;

use App\Http\Helpers\Modal;

class InvoicePaymentController extends Controller
{
    protected $routeResource = 'payments';

	public function store(InvoicePaymentRequest $request)
	{
		$status = true;
		$payment = null;
		$invoice = Invoice::find($request->invoice_id);

		try {
            $payment = InvoicePayment::create([
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

		return response()->json([$status, 'payment' => $payment->load(["invoicePaymentType"])]);
	}

	public function update(InvoicePaymentRequest $request, InvoicePayment $payment)
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

		return response()->json([$status, 'payment' => $payment->load(["invoicePaymentType"])]);
	}

	public function destroy(InvoicePayment $payment)
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
			$payment = InvoicePayment::find($id);
			$paymentTypes = InvoicePaymentType::all();
			$modal = new Modal($this->routeResource.'Modal', 'Edit InvoicePayment', $this->routeResource, ["invoice" => $invoice, "payment" => $payment, "paymentTypes" => $paymentTypes]);
			return $modal->getModalAddEdit(request()->type, $id);
		}else{
			$paymentTypes = InvoicePaymentType::all();
			$modal = new Modal($this->routeResource.'Modal', 'Add InvoicePayment', $this->routeResource, ["invoice" => $invoice, "paymentTypes" => $paymentTypes]);
			return $modal->getModalAddEdit(request()->type);
		}

	}
}
