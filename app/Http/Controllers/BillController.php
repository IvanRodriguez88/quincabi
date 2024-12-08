<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\Modal;
use App\Http\Requests\BillRequest;

use App\Models\Bill;
use App\Models\BillType;
use App\Models\ProjectPaymentType;

class BillController extends Controller
{
    protected $routeResource = 'invoices';

    public function index()
    {
        $routeResource = $this->routeResource;

        $bills = Bill::all();

        $heads = [
            'ID',
			'Bill Type',
			'Type',
			'Amount',
			'Description',
			'Date',
			'Actions'
        ];
        return view('bills.index', compact('heads', 'bills', 'routeResource'));
    }

    public function create()
	{
        $billTypes = BillType::where("is_active", 1)->get();
		$projectPaymentTypes = ProjectPaymentType::where("is_active", 1)->get();

        return view('bill_types.create', compact("projectPaymentTypes", "billTypes"));
    }


	public function store(BillRequest $request)
	{
		$status = true;
		$bill = null;
		try {
			$params = [
				'description' => $request->description,
				'bill_type_id' => $request->bill_type_id,
				'project_id' => $request->project_id,
				'project_payment_type_id' => $request->project_payment_type_id,
				'amount' => $request->amount,
				'date' => $request->date,
				"created_by" => auth()->id(),
				"updated_by" => auth()->id(),
			];

            $bill = Bill::create($params);

        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json(["status" => $status, 'bill' => $bill]);
	}

	public function update(BillRequest $request, Bill $bill)
	{
		$status = true;
		try {
            $bill->update([
				'description' => $request->description,
				'bill_type_id' => $request->bill_type_id,
				'project_id' => $request->project_id,
				'project_payment_type_id' => $request->project_payment_type_id,
				'amount' => $request->amount,
				'date' => $request->date,
				"updated_by" => auth()->id(),
				"updated_at" => now()
			]);
		
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json(["status" => $status, 'bill' => $bill]);
	}

	public function edit(Bill $bill)
	{
		$billTypes = BillType::where("is_active", 1)->get();
		$projectPaymentTypes = ProjectPaymentType::where("is_active", 1)->get();

        return view('bills.edit', compact("bill", "billTypes", "projectPaymentTypes"));
    }

	public function destroy(Bill $bill)
	{
		$status = true;
        try {
            $bill->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }
		return response()->json([$status, "bill" => $bill]);
	}
   
}
