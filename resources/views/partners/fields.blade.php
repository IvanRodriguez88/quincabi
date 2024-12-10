<div class="row">
    <x-adminlte-input 
		value="{{($data->name) ?? ''}}" 
		name="name" 
		label="Name" 
		placeholder="Name of the partner"
        fgroup-class="col-md-6" 
		disable-feedback
		label-class="required"
	/>
	<x-adminlte-input 
		value="{{($data->percentage) ?? ''}}" 
		name="percentage" 
		label="Parcentage" 
		placeholder="Percentage of the partner"
        fgroup-class="col-md-6" 
		disable-feedback
		label-class="required"
	/>
</div>