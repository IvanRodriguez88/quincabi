<input type="hidden" id="category_id" value="{{$data->id ?? ''}}">
<div class="row">
    <x-adminlte-input 
		id="category_name"
		value="{{($data->name) ?? ''}}" 
		name="name" 
		label="Name" 
		placeholder="Name of the category"
        fgroup-class="col-md-12 mb-0" 
		disable-feedback
		label-class="required"
	/>
</div>
<hr>
<div class="row">
	<div class="col-md-6">
		<div class="d-flex gap-3 align-items-center justify-content-between mb-3">
			<x-adminlte-input 
				id="subcategory_name"
				name="subcategory_name" 
				placeholder="Name of the subcategory"
				fgroup-class="w-100 m-0" 
				disable-feedback
			/>
			<a onclick="addSubcategory()" class="btn btn-default ml-3"><i class="fas fa-plus"></i></a>
		</div>
		<div class="info-box">
			<span class="info-box-icon bg-info"><i class="fas fa-stream"></i></span>
			<div class="info-box-content">

				<span class="info-box-text"><b>SUBCATEGORIES</b></span>
				<span class="info-box-number">
					<ol id="subcategories_list" class='pl-4'>
						@foreach ($data->subcategories as $subcategory)
							@include('categories.subcateogry-item', [
								'id' => $subcategory->id,
								'subcategory' => $subcategory->name
							])
						@endforeach
					</ol>
				</span>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="d-flex gap-3 align-items-center justify-content-between mb-3">
			<x-adminlte-input 
				id="item_name"
				name="item_name" 
				placeholder="Name of the categroy item"
				fgroup-class="w-100 m-0" 
				disable-feedback
			/>
			<a onclick="addItem()" class="btn btn-default ml-3"><i class="fas fa-plus"></i></a>
		</div>
		<input type="hidden" id="subcategory_id">
		
		<div id="category-items">
			<p class="">Select a subcategory</p>
		</div>
	</div>
</div>

<script>
	$(function () {
		$("#subcategories_list").sortable({});
	})
</script>

