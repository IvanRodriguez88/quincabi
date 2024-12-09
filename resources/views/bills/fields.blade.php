<input type="hidden" name="project_id" value={{$data['bill']->project_id ?? $data['project_id']}}>

<div class="row">
	<x-adminlte-select id="bill_type_id" name="bill_type_id" label="Bill Type" fgroup-class="col-md-4" required>
		<option disabled selected>Select bill type...</option>
		@foreach ($data['billTypes'] as $billType)
			<option value="{{$billType->id}}" {{$billType->id == ($data['bill']->bill_type_id ?? 0) ? "selected" : ""}}>{{$billType->name}}</option>
		@endforeach
	</x-adminlte-select>

	<x-adminlte-select id="project_payment_type_id" name="project_payment_type_id" label="Payment Type" fgroup-class="col-md-4" required>
		<option disabled selected>Select payment type...</option>
		@foreach ($data['projectPaymentTypes'] as $paymentType)
			<option value="{{$paymentType->id}}" {{$paymentType->id == ($data['bill']->project_payment_type_id ?? 0) ? "selected" : ""}}>{{$paymentType->name}}</option>
		@endforeach
	</x-adminlte-select>
	
	<x-adminlte-input 
		value="{{$data['bill']->amount ?? ''}}" 
		name="amount" 
		label="Amount" 
		type="number"
		placeholder="Amount"
        fgroup-class="col-md-4" 
		disable-feedback
	/>
</div>
<div class="row">
	<div class="col-md-4">
		<label for="date">Date</label>
		<input type="date" class="form-control" name="date" id="date" required
				value="{{isset($data['bill']) ? date('Y-m-d', strtotime($data['bill']->date)) : ''}}">
	</div>
	<x-adminlte-input 
		value="{{$data['bill']->description ?? ''}}" 
		name="description" 
		label="Description" 
		type="text"
		placeholder="Description"
        fgroup-class="col-md-8" 
		disable-feedback
	/>
</div>