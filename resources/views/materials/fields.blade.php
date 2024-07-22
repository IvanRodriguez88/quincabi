<div class="row">
    <x-adminlte-input 
		value="{{($data['material']->name) ?? ''}}" 
		name="name" 
		label="Name" 
		placeholder="Name of the material"
        fgroup-class="col-md-12" 
		disable-feedback
		label-class="required"
	/>

</div>
<div class="row">

	<x-adminlte-input 
		value="{{($data['material']->cost) ?? ''}}" 
		name="cost" 
		label="Cost" 
		type="number" 
		placeholder="Cost of the material"
		fgroup-class="col-md-4" 
		disable-feedback
	/>
	
	
	
	<x-adminlte-input 
		value="{{($data['material']->price) ?? ''}}" 
		name="price" 
		label="Price" 
		type="number" 
		placeholder="Price of the material"
		fgroup-class="col-md-4" 
		disable-feedback
	/>

	@if (isset($data['material']))
		<x-adminlte-select id="category_id" name="category_id" label="Main category" fgroup-class="col-md-4">
			<option disabled>Select a category...</option>
			@foreach ($data["categories"] as $category)
				<option value="{{$category->id}}" {{$category->id == $data["material"]->categoryMaterials[0]->category_id ? "selected" : ""}}>{{$category->name}}</option>
			@endforeach
		</x-adminlte-select>
	@else
		<x-adminlte-select id="category_id" name="category_id" label="Main category" fgroup-class="col-md-4">
			<option disabled selected>Select a category...</option>
			@foreach ($data["categories"] as $category)
				<option value="{{$category->id}}">{{$category->name}}</option>
			@endforeach
		</x-adminlte-select>
	@endif

</div>

@if (isset($data['material']))
	<div id="subcategories" class="row form-group">
		@include("materials.subcategories", ["material" => $data['material']])
	</div>
@else
	<div id="subcategories" class="row form-group">

	</div>
@endif

<script>
	$("#category_id").on("change", function(e) {
		const category_id = $(this).val()
		$.ajax({
			type: "GET",
			url: `${getBaseUrl()}/categories/getsubcategories/${category_id}`,
			success: function (response) {
				$("#subcategories").empty().append(response).hide().slideDown('slow')
			},
			error: function (xhr, textStatus, errorThrown) {
				toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
			},
		});
	})
</script>