<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\Modal;
use App\Http\Requests\InvoiceRequest;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\Material;

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
            'Date Issued',
            'Due Date',
            'Is Paid',
			'Actions'
        ];
        return view('invoices.index', compact('heads', 'invoices', 'routeResource'));
    }

    public function create(){
        $lastIdInvoice = Invoice::orderBy("id", "desc")->first()->id ?? 0;
        $clients = Client::where("is_active", 1)->get();
        return view('invoices.create', compact("clients", "lastIdInvoice"));
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
}
