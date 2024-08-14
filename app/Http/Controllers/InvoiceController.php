<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\Modal;
use App\Http\Requests\InvoiceRequest;

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
            'Client',
			'Total',
            'Date Issued',
            'Due Date',
            'Is Paid',
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

	public function store(Request $request)
	{
		$status = true;
		$invoice = null;
		try {
            $invoice = Invoice::create([
				'client_id' => $request->client_id,
				'date_issued' => now(),
				'date_due' => $request->date_due,
				"created_by" => auth()->id(),
				"updated_by" => auth()->id(),
			]);


			//Crear items de subcategorias
			foreach ($request->materials as $key => $row) {
				$material = Material::find($row["material_id"]);
				$amount = $row["amount"];
				$price = $row["price"];
				InvoiceRow::create([
					'invoice_id' => $invoice->id,
					'material_id' => $material->id, 
					'extra_name' => $material->extra_name, 
					'amount' => $amount, 
					'unit_cost' => $material->cost, 
					'unit_price' => $price
				]);
			}


        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status, 'invoice' => $invoice]);
	}

    public function addMaterial(Request $request)
    {
        $uniqueId = uniqid();
        $material = Material::find($request->material_id);
        $amount = $request->amount;
        $unit_price = $request->unit_price;
        $total = $unit_price * $amount;
        return view("invoices.material-row", compact("material", "amount", "unit_price", "total", "uniqueId"))->render();
    }

	public function getClientInfo(Client $client)
	{
		return view("invoices.client-info", compact("client"))->render();
	}
}
