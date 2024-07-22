@if (isset($material))
	@foreach ($material->categoryMaterials[0]->category->subcategories as $key => $subcategory)
	<x-adminlte-select name="subcategory[{{$subcategory->id}}]" label="{{$key + 1}}. {{$subcategory->name}}" fgroup-class="col-md-4">
		<option selected>Select an option...</option>
		@foreach ($subcategory->categoryItems as $categoryItem)
			@php $selected = false; @endphp
			@foreach ($material->categoryMaterials as $key => $categoryMaterial)
				@if ($categoryItem->id == $categoryMaterial->category_item_id)
					@php $selected = true; @endphp
				@endif
			@endforeach
			<option {{$selected ? "selected" : ""}} value="{{$categoryItem->id}}">{{$categoryItem->name}}</option>
		@endforeach
	</x-adminlte-select>
	@endforeach

@else
	@foreach ($category->subcategories as $key => $subcategory)
	<x-adminlte-select name="subcategory[{{$subcategory->id}}]" label="{{$key + 1}}. {{$subcategory->name}}" fgroup-class="col-md-4">
		<option value="" selected>Select an option...</option>
		@foreach ($subcategory->categoryItems as $categoryItem)
			<option value="{{$categoryItem->id}}">{{$categoryItem->name}}</option>
		@endforeach
	</x-adminlte-select>
	@endforeach
@endif