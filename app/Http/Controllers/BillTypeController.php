<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BillTypeRequest;

use App\Models\BillType;
use App\Http\Helpers\Modal;

class BillTypeController extends Controller
{
	protected $routeResource = 'bill_types';
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		$routeResource = $this->routeResource;
		
		$bill_types = BillType::all();
        $heads = [
            'ID',
            'Name',
			'Actions'
        ];
        return view('bill_types.index', compact('heads', 'bill_types', 'routeResource'));
    }

	public function store(BillTypeRequest $request)
	{
		$status = true;
		$bill_type = null;
		try {
            $bill_type = BillType::create([
				'name' => $request->name,
				"created_by" => auth()->id(),
				"updated_by" => auth()->id(),
			]);
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status, 'bill_type' => $bill_type]);
	}

	public function update(BillTypeRequest $request, BillType $bill_type)
	{
		$status = true;
		try {
            $bill_type->update([
				'name' => $request->name,
				"updated_by" => auth()->id(),
				"updated_at" => now()
			]);
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status, 'bill_type' => $bill_type]);
	}

	public function destroy(BillType $bill_type)
	{
		$status = true;
        try {
            $bill_type->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status]);
	}


	public function getAddEditModal($id = null)
	{
		if ($id !== 'undefined'){
			$bill_type = BillType::find($id);
			$modal = new Modal($this->routeResource.'Modal', 'Edit Bill type', $this->routeResource, $bill_type);
			return $modal->getModalAddEdit(request()->type, $id);
		}else{
			$modal = new Modal($this->routeResource.'Modal', 'Add Bill type', $this->routeResource);
			return $modal->getModalAddEdit(request()->type);
		}

	}
}
