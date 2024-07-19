<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SupplierRequest;

use App\Models\Supplier;
use App\Http\Helpers\Modal;

class SupplierController extends Controller
{
	protected $routeResource = 'suppliers';
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		$routeResource = $this->routeResource;
		
		$suppliers = Supplier::all();
        $heads = [
            'ID',
            'Name',
            'Address',
			'Actions'
        ];
        return view('suppliers.index', compact('heads', 'suppliers', 'routeResource'));
    }

	public function store(SupplierRequest $request)
	{
		$status = true;
		$supplier = null;
		try {
            $supplier = Supplier::create([
				'name' => $request->name,
				"phone" => $request->phone,
				"address" => $request->address,
				"email" => $request->email,
				"created_by" => auth()->id(),
				"updated_by" => auth()->id(),
			]);
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status, 'supplier' => $supplier]);
	}

	public function update(SupplierRequest $request, Supplier $supplier)
	{
		$status = true;
		try {
            $supplier->update([
				'name' => $request->name,
				"phone" => $request->phone,
				"address" => $request->address,
				"email" => $request->email,
				"updated_by" => auth()->id(),
				"updated_at" => now()
			]);
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status, 'supplier' => $supplier]);
	}

	public function destroy(Supplier $supplier)
	{
		$status = true;
        try {
            $supplier->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status]);
	}


	public function getAddEditModal($id = null)
	{
		if ($id !== 'undefined'){
			$supplier = Supplier::find($id);
			$modal = new Modal($this->routeResource.'Modal', 'Edit supplier', $this->routeResource, $supplier);
			return $modal->getModalAddEdit(request()->type, $id);
		}else{
			$modal = new Modal($this->routeResource.'Modal', 'Add supplier', $this->routeResource);
			return $modal->getModalAddEdit(request()->type);
		}

	}
}
