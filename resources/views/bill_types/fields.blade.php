<div class="row">
    <x-adminlte-input 
		value="{{($data->name) ?? ''}}" 
		name="name" 
		label="Name" 
		placeholder="Name of the bill type"
        fgroup-class="col-md-12" 
		disable-feedback
		label-class="required"
	/>
</div>