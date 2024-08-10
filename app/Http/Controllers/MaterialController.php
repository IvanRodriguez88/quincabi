<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\Modal;
use App\Http\Requests\MaterialRequest;

use App\Models\Material;
use App\Models\Category;
use App\Models\CategoryMaterial;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;


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

	public function store(MaterialRequest $request)
	{
		$status = true;
		$material = null;
		try {
            $material = Material::create([
				'name' => $request->name,
				'cost' => $request->cost,
				'price' => $request->price,
				'supplier_id' => $request->supplier_id,
				'extra_name' => $request->extra_name,
				"created_by" => auth()->id(),
				"updated_by" => auth()->id(),
			]);

			//Crear categoria
			$parent = CategoryMaterial::create([
				"category_id" => $request->category_id,
				"material_id" => $material->id
			]);

			//Crear items de subcategorias
			foreach ($request->subcategory as $key => $subcategory) {
				$parent = CategoryMaterial::create([
					"category_id" => $request->category_id,
					"parent_category_material_id" => $parent->id,
					"category_item_id" => $subcategory,
					"material_id" => $material->id
				]);
			}


        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status, 'material' => $material]);
	}

	public function update(MaterialRequest $request, Material $material)
	{
		$status = true;
		try {
            $material->update([
				'name' => $request->name,
				'cost' => $request->cost,
				'price' => $request->price,
				'supplier_id' => $request->supplier_id,
				'extra_name' => $request->extra_name,
				"updated_by" => auth()->id(),
			]);


			$material->categoryMaterials()->delete();
			//Crear categoria
			$parent = CategoryMaterial::create([
				"category_id" => $request->category_id,
				"material_id" => $material->id
			]);

			//Crear items de subcategorias
			foreach ($request->subcategory as $key => $subcategory) {
				if ($subcategory != "Select an option...") {
					$parent = CategoryMaterial::create([
						"category_id" => $request->category_id,
						"parent_category_material_id" => $parent->id,
						"category_item_id" => $subcategory,
						"material_id" => $material->id
					]);
				}
			}

        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status, 'material' => $material]);
	}

	public function destroy(Material $material)
	{
		$status = true;
        try {
            $material->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;

        }

		return response()->json([$status]);
	}

    public function getAddEditModal($id = null)
	{
		if ($id !== 'undefined'){
			$material = Material::find($id);
            $data = [
                "material" => $material,
                "categories" => Category::where("is_active", 1)->get(),
				"suppliers" => Supplier::where("is_active",1)->pluck("name", "id")
            ];

			$modal = new Modal($this->routeResource.'Modal', 'Edit material', $this->routeResource, $data, ['size' => 'xl']);
			return $modal->getModalAddEdit(request()->type, $id);
		}else{
			$data = [
                "categories" => Category::where("is_active", 1)->get(),
				"suppliers" => Supplier::where("is_active",1)->pluck("name", "id")
            ];
			$modal = new Modal($this->routeResource.'Modal', 'Add material', $this->routeResource, $data);
			return $modal->getModalAddEdit(request()->type);
		}
	}

	public function getDataAutocomplete()
    {
        $materials = Material::select(
            "id",
            DB::raw("materials.name as name")
        )->get();

        $formattedMaterials = $materials->map(function ($material) {
            return [
                'id' => $material->id,
                'name' => $material->name
            ];
        });

        return response()->json($formattedMaterials);    
    }

	public function getById(Material $material)
    {
        return response()->json($material);    
    }


	
}
