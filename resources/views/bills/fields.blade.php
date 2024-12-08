<div class="row">
    <x-adminlte-input 
		value="{{($data->name) ?? ''}}" 
		name="name" 
		label="Name" 
		placeholder="Name of the client"
        fgroup-class="col-md-6" 
		disable-feedback
		label-class="required"
	/>

	<x-adminlte-input 
		value="{{($data->phone) ?? ''}}" 
		name="phone" 
		label="Phone" 
		placeholder="Phone of the client"
        fgroup-class="col-md-6" 
		disable-feedback
	/>

	<x-adminlte-input 
		value="{{($data->address) ?? ''}}" 
		name="address" 
		label="Address" 
		placeholder="Address of the client"
        fgroup-class="col-md-6" 
		disable-feedback
	/>

	<x-adminlte-input 
		value="{{($data->email) ?? ''}}" 
		name="email" 
		label="Email" 
		type="email" 
		placeholder="Email of the client"
        fgroup-class="col-md-6" 
		disable-feedback
	/>
</div>