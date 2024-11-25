<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\Modal;
use App\Http\Requests\InvoiceRequest;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\Material;
use App\Models\InvoiceRow;

class InvoiceController extends Controller
{
    protected $routeResource = 'invoices';

    public function index()
    {
        $routeResource = $this->routeResource;

        $invoices = Invoice::all();

        $heads = [
            'ID',
			'Name',
			'Cost',
			'Total',
            'Date Issued',
            'Due Date',
			'Actions'
        ];
        return view('invoices.index', compact('heads', 'invoices', 'routeResource'));
    }

    public function create()
	{
        $lastIdInvoice = Invoice::orderBy("id", "desc")->first()->id ?? 0;
        $clients = Client::where("is_active", 1)->get();
        return view('invoices.create', compact("clients", "lastIdInvoice"));
    }

	public function store(InvoiceRequest $request)
	{
		$status = true;
		$invoice = null;
		
		try {
            $invoice = Invoice::create([
				'name' => $request->name,
				'client_id' => $request->client_id,
				'date_issued' => now(),
				'date_due' => $request->date_due,
				"created_by" => auth()->id(),
				"updated_by" => auth()->id(),
			]);



			//Crear items de subcategorias
			foreach ($request->materials as $key => $row) {
				$material = null;
				if ($row["material_id"] != null) {
					$material = Material::find($row["material_id"]);
					$material_name = $material->name." ".$material->extra_name;
				}else{
					$material_name = $row["material_name"];
				}
				$amount = $row["amount"];
				$price = $row["price"];
				InvoiceRow::create([
					'invoice_id' => $invoice->id,
					'material_id' => $material->id ?? null, 
					'name' => $material_name, 
					'amount' => $amount, 
					'unit_cost' => $row["cost"], 
					'unit_price' => $price
				]);
			}


        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json(["status" => $status, 'invoice' => $invoice]);
	}

	public function update(InvoiceRequest $request, Invoice $invoice)
	{
		$status = true;
		try {
            $invoice->update([
				'name' => $request->name,
				'client_id' => $request->client_id,
				'date_due' => $request->date_due,
				"updated_by" => auth()->id(),
				"updated_at" => now()
			]);

			$invoice->invoiceRows()->delete();

			foreach ($request->materials as $key => $row) {
				$material = null;
				if ($row["material_id"] != null) {
					$material = Material::find($row["material_id"]);
					$material_name = $material->name." ".$material->extra_name;
				}else{
					$material_name = $row["material_name"];
				}
				$amount = $row["amount"];
				$price = $row["price"];
				InvoiceRow::create([
					'invoice_id' => $invoice->id,
					'material_id' => $material->id ?? null, 
					'name' => $material_name, 
					'amount' => $amount, 
					'unit_cost' => $row["cost"], 
					'unit_price' => $price
				]);
			}
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json(["status" => $status, 'invoice' => $invoice]);
	}


	public function edit(Invoice $invoice)
	{
        return view('invoices.edit', compact("invoice"));
    }

	public function show(Invoice $invoice)
	{
        return view('invoices.show', compact("invoice"));
    }

	public function destroy(Invoice $invoice)
	{
		$status = true;
        try {
			$invoice->invoiceRows()->delete();
            $invoice->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status]);
	}

	public function showPayments(Invoice $invoice)
	{
        $heads = [
            'ID',
            'Payment Type',
			'Amount',
			'Date',
			'Actions'
        ];
        return view('invoices.payments', compact("invoice", "heads"));
    }

	public function payInvoice(Invoice $invoice)
	{
		$status = true;
		try {
			$invoice->update([
				"is_paid" => 1,
				"updated_by" => auth()->id(),
				"updated_at" => now()
			]);
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status, 'invoice' => $invoice]);
	}

	public function getButtons(Invoice $invoice)
	{
		return view("invoices.buttons", compact("invoice"))->render();		
	}



    public function addMaterial(Request $request)
    {
        $uniqueId = uniqid();
		$material = null;
		$free_material = null;
		if ($request->material_id != null) {
			$material = Material::find($request->material_id);
		}else {
			$free_material = $request->free_material_input;
		}
        $amount = $request->amount;
        $unit_price = $request->unit_price;
		$unit_cost = $request->unit_cost;
        $total = $unit_price * $amount;

        return view("invoices.material-row", compact("material", "free_material", "amount", "unit_price", "unit_cost", "total", "uniqueId"))->render();
    }

	public function getClientInfo(Client $client)
	{
		return view("invoices.client-info", compact("client"))->render();
	}

	public function pdf(Invoice $invoice)
	{
		$data = [
			"invoice" => $invoice
		];
		$pdf = Pdf::loadView('invoices.pdf', $data);
    	return $pdf->stream();
	}
}
