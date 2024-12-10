<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProjectPartnerRequest;

use App\Models\ProjectPartner;
use App\Models\Project;
use App\Models\Partner;

use App\Http\Helpers\Modal;

class ProjectPartnerController extends Controller
{
	protected $routeResource = 'project_partners';

	public function store(ProjectPartnerRequest $request)
	{
		$project = Project::find($request->project_id);
		$status = true;
		try {
			$project_partner = ProjectPartner::create([
				"project_id" => $request->project_id,
				"partner_id" => $request->partner_id,
				"percentage" => $request->percentage,
				"amount" => $request->amount,
			]);
			$project_partner->load('partner');

        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status, 'project_partner' => $project_partner, 'project' => $project]);
	}

	public function update(ProjectPartnerRequest $request, ProjectPartner $project_partner)
	{
		$project = Project::find($project_partner->project_id);
		$status = true;
		try {
            $project_partner->update([
				"partner_id" => $request->partner_id,
				"percentage" => $request->percentage,
				"amount" => $request->amount,
			]);
			$project_partner->load('partner');
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }
		return response()->json([$status, 'project_partner' => $project_partner, 'project' => $project]);
	}

	public function destroy(ProjectPartner $project_partner)
	{
		$project = Project::find($project_partner->project_id);
		$status = true;
        try {
            $project_partner->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status, 'project' => $project]);
	}

    public function getAddEditModal(Project $project, $id = null)
	{
		if ($id !== 'undefined'){
			$project_partner = ProjectPartner::find($id);
            $data = [
				"partners" => Partner::where("is_active", 1)->get(),
				"project" => $project,
				"project_partner" => $project_partner
            ];
			$modal = new Modal($this->routeResource.'Modal', 'Edit Partner', $this->routeResource, $data, ["function" => "savePartner()"]);
			return $modal->getModalAddEdit(request()->type, $id);
		}else{
			$data = [
				"partners" => Partner::where("is_active", 1)->get(),
				"project" => $project
			];
			$modal = new Modal($this->routeResource.'Modal', 'Add Partner', $this->routeResource, $data, ["function" => "savePartner()"]);
			return $modal->getModalAddEdit(request()->type);
		}

		
	}

}
