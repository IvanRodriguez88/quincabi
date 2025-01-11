<input type="hidden" name="project_id" value={{$data['project']->id ?? ""}}>
<div class="row">
	<x-adminlte-select id="supplier_id" name="supplier_id" label="Supplier" fgroup-class="col-md-8" required>
		<option disabled selected>Select a supplier...</option>
		@foreach ($data['suppliers'] as $supplier)
			<option value="{{$supplier->id}}" {{$supplier->id == ($data['project_supplier']->supplier_id ?? 0) ? "selected" : ""}}>{{$supplier->name}}</option>
		@endforeach
	</x-adminlte-select>

	<x-adminlte-input 
		value="{{$data['project_supplier']->amount ?? ''}}" 
		name="amount" 
		label="Amount" 
		type="number"
		placeholder="Amount"
        fgroup-class="col-md-4" 
		disable-feedback
	/>

</div>