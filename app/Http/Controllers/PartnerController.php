<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PartnerRequest;

use App\Models\Partner;
use App\Http\Helpers\Modal;

class PartnerController extends Controller
{
	protected $routeResource = 'partners';
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		$routeResource = $this->routeResource;
		
		$partners = Partner::all();
        $heads = [
            'ID',
            'Name',
			'Percentage',
			'Actions'
        ];
        return view('partners.index', compact('heads', 'partners', 'routeResource'));
    }

	public function store(PartnerRequest $request)
	{
		$status = true;
		$partner = null;
		try {
            $partner = Partner::create([
				'name' => $request->name,
				'percentage' => $request->percentage,
				"created_by" => auth()->id(),
				"updated_by" => auth()->id(),
			]);
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status, 'partner' => $partner]);
	}

	public function update(PartnerRequest $request, Partner $partner)
	{
		$status = true;
		try {
            $partner->update([
				'name' => $request->name,
				'percentage' => $request->percentage,
				"updated_by" => auth()->id(),
				"updated_at" => now()
			]);
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status, 'partner' => $partner]);
	}

	public function destroy(Partner $partner)
	{
		$status = true;
        try {
            $partner->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status]);
	}


	public function getAddEditModal($id = null)
	{
		if ($id !== 'undefined'){
			$partner = Partner::find($id);
			$modal = new Modal($this->routeResource.'Modal', 'Edit partner', $this->routeResource, $partner);
			return $modal->getModalAddEdit(request()->type, $id);
		}else{
			$modal = new Modal($this->routeResource.'Modal', 'Add partner', $this->routeResource);
			return $modal->getModalAddEdit(request()->type);
		}

	}

	public function getPartner(Partner $partner)
	{
		return response()->json($partner);
	}
}
