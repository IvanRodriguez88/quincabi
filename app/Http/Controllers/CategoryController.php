<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Http\Helpers\Modal;

use App\Models\Category;
use App\Models\CategoryItem;

class CategoryController extends Controller
{
	protected $routeResource = 'categories';

    public function index()
    {
		$routeResource = $this->routeResource;
		
		$categories = Category::all();
        $heads = [
            'ID',
            'Name',
			'Actions'
        ];
        return view('categories.index', compact('heads', 'categories', 'routeResource'));
    }

	public function store(CategoryRequest $request)
	{
		$status = true;
		$category = null;
		try {
            $category = Category::create([
				'name' => $request->name,
				"created_by" => auth()->id(),
				"updated_by" => auth()->id(),
			]);
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status, 'category' => $category]);
	}

	public function update(CategoryRequest $request, Category $category)
	{
		$status = true;
		$subcategories = $request->subcategories;
		$itemsDelete = $request->itemsDelete;
		try {
			$category->update([
				'name' => $request->name,
				"updated_by" => auth()->id(),
				"updated_at" => now()
			]);
			//Modificar las subcategorias
			foreach ($subcategories as $key => $subcategory) {
				// Actualiza el orden de los elementos existentes
				CategoryItem::where('id', $subcategory)->update(['order' => $key + 1]);
			}

			// Elimina los registros que ya no están presentes en la nueva lista
			CategoryItem::where('category_id', $category->id)->where("category_item_id", null)->whereNotIn('id', $subcategories)->delete();
			if (!is_null($itemsDelete)) {
				CategoryItem::whereIn('id', $itemsDelete)->delete();
			}

        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
        }

		return response()->json([$status, 'category' => $category]);
	}

	public function destroy(Category $category)
	{
		$message = "The category has been deleted successfully";
		$status = true;
        try {
            $category->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $e->getMessage();
        }

		return response()->json(["status" => $status, "message" => $message]);
	}

	public function getAddEditModal($id = null)
	{
		if ($id !== 'undefined'){
			$category = Category::find($id);
			$modal = new Modal($this->routeResource.'Modal', 'Edit category', $this->routeResource, $category, ['size' => 'xl']);
			return $modal->getModalAddEdit(request()->type, $id, 'edit-fields');
		}else{
			$modal = new Modal($this->routeResource.'Modal', 'Add category', $this->routeResource);
			return $modal->getModalAddEdit(request()->type);
		}
	}

	public function saveSubcategory($category_id)
	{
		$lastOrder = CategoryItem::where('category_id', $category_id)->orderBy('order', 'desc')->first()->order ?? 1;
		$subcategory = CategoryItem::create([
			'category_id' => $category_id,
			'name' => request()->all()['name'], 
			'order' => $lastOrder + 1
		]);

		$id = $subcategory->id;
		$subcategory = $subcategory->name;

		return view('categories.subcateogry-item', compact('id', 'subcategory'))->render();
	}

	public function selectSubcategory(CategoryItem $category)
	{
		return view('categories.category-items', compact('category'))->render();
	}

	public function saveItem($subcategory_id){
		$subcategory = CategoryItem::find($subcategory_id);
		$item = CategoryItem::create([
			'category_id' => $subcategory->category_id,
			'category_item_id' => $subcategory->id,
			'name' => request()->all()['name'], 
		]);
		$id = $item->id;
		$item = $item->name;

		return view('categories.item', compact('id', 'item'))->render();

	}

	public function getSubcategories(Category $category) 
	{
		return view("materials.subcategories", compact("category"))->render();
	}
}
