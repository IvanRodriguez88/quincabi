<div class="row">
    <x-adminlte-input 
		value="{{($data->name) ?? ''}}" 
		name="name" 
		label="Name" 
		placeholder="Name of the worker"
        fgroup-class="col-md-6" 
		disable-feedback
		label-class="required"
	/>
	
	<x-adminlte-input 
		value="{{($data->hourly_pay) ?? ''}}" 
		name="hourly_pay" 
		label="Horuly Pay" 
		placeholder="Hourly Pay of the worker"
		fgroup-class="col-md-6" 
		disable-feedback
		type="number"
	/>

	<x-adminlte-input 
		value="{{($data->phone) ?? ''}}" 
		name="phone" 
		label="Phone" 
		placeholder="Phone of the worker"
        fgroup-class="col-md-6" 
		disable-feedback
	/>


	<x-adminlte-input 
		value="{{($data->email) ?? ''}}" 
		name="email" 
		label="Email" 
		type="email" 
		placeholder="Email of the worker"
        fgroup-class="col-md-6" 
		disable-feedback
	/>
</div>