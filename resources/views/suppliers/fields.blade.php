<div class="row">
    <x-adminlte-input 
		value="{{($data->name) ?? ''}}" 
		name="name" 
		label="Name" 
		placeholder="Name of the supplier"
        fgroup-class="col-md-6" 
		disable-feedback
		label-class="required"
	/>

	<x-adminlte-input 
		value="{{($data->address) ?? ''}}" 
		name="address" 
		label="Address" 
		placeholder="Address of the supplier"
        fgroup-class="col-md-6" 
		disable-feedback
	/>

</div>