<div class="row">
    <x-adminlte-input 
		value="{{($data['material']->name) ?? ''}}" 
		name="name" 
		label="Name" 
		placeholder="Name of the client"
        fgroup-class="col-md-12" 
		disable-feedback
		label-class="required"
	/>

	@if (count($data['material']->categoryMaterials) > 0)
		@foreach ($data['material']->categoryMaterials as $key => $categoryMaterial)
			@if($key == 0)
				<x-adminlte-select name="categoryMaterials[{{$categoryMaterial->category_id}}]" label="Main category" fgroup-class="col-md-4">
					<option disabled>Select a category...</option>
					@foreach ($data["categories"] as $category)
						<option {{$category->id == $data["material"]->category_id ? "selected" : ""}}>{{$category->name}}</option>
					@endforeach
				</x-adminlte-select>
			@else
				<x-adminlte-select name="categoryMaterials[{{$categoryMaterial->category_item_id}}]" label="{{$categoryMaterial->categoryItem->categoryItem->name}}" fgroup-class="col-md-4">
					<option disabled>Select a category...</option>
					@foreach ($categoryMaterial->categoryItem->categoryItem->categoryItems as $categoryItem)
						<option {{$categoryItem->id == $categoryMaterial->category_item_id ? "selected" : ""}}>{{$categoryItem->name}}</option>
					@endforeach
				</x-adminlte-select>
			@endif
		@endforeach
	@endif

	

	<x-adminlte-input 
		value="{{($data['material']->cost) ?? ''}}" 
		name="cost" 
		label="Cost" 
		type="number" 
		placeholder="Cost of the material"
        fgroup-class="col-md-6" 
		disable-feedback
	/>

	

	<x-adminlte-input 
		value="{{($data['material']->price) ?? ''}}" 
		name="price" 
		label="Price" 
		type="number" 
		placeholder="Price of the material"
        fgroup-class="col-md-6" 
		disable-feedback
	/>
</div>