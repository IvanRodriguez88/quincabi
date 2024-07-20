<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\Modal;
use App\Models\Material;
use App\Models\Category;

class MaterialController extends Controller
{
	protected $routeResource = 'materials';

    public function index()
    {
        $routeResource = $this->routeResource;

        $materials = Material::all();
        $heads = [
            'ID',
            'Name',
			'Actions'
        ];
        return view('materials.index', compact('heads', 'materials', 'routeResource'));
    }

    public function getAddEditModal($id = null)
	{
		if ($id !== 'undefined'){
			$material = Material::find($id);

            $data = [
                "material" => $material,
                "categories" => Category::where("is_active", 1)->get()
            ];

			$modal = new Modal($this->routeResource.'Modal', 'Edit material', $this->routeResource, $data, ['size' => 'xl']);
			return $modal->getModalAddEdit(request()->type, $id);
		}else{
			$modal = new Modal($this->routeResource.'Modal', 'Add material', $this->routeResource);
			return $modal->getModalAddEdit(request()->type);
		}
	}
}
