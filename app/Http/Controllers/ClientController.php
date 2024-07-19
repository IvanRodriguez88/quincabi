<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;

use App\Models\Client;
use App\Http\Helpers\Modal;

class ClientController extends Controller
{
	protected $routeResource = 'clients';
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		$routeResource = $this->routeResource;
		
		$clients = Client::all();
        $heads = [
            'ID',
            'Name',
            'Phone',
            'Email',
            'Address',
			'Actions'
        ];
        return view('clients.index', compact('heads', 'clients', 'routeResource'));
    }

	public function store(ClientRequest $request)
	{
		$status = true;
		$client = null;
		try {
            $client = Client::create([
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

		return response()->json([$status, 'client' => $client]);
	}

	public function update(ClientRequest $request, Client $client)
	{
		$status = true;
		try {
            $client->update([
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

		return response()->json([$status, 'client' => $client]);
	}

	public function destroy(Client $client)
	{
		$status = true;
        try {
            $client->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status]);
	}


	public function getAddEditModal($id = null)
	{
		if ($id !== 'undefined'){
			$client = Client::find($id);
			$modal = new Modal($this->routeResource.'Modal', 'Edit Client', $this->routeResource, $client);
			return $modal->getModalAddEdit(request()->type, $id);
		}else{
			$modal = new Modal($this->routeResource.'Modal', 'Add Client', $this->routeResource);
			return $modal->getModalAddEdit(request()->type);
		}

	}
}
