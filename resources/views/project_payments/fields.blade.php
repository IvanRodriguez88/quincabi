<input type="hidden" name="project_id" value={{$data['project']->id ?? ""}}>
<div class="row">
	<x-adminlte-select id="project_payment_type_id" name="project_payment_type_id" label="Payment Type" fgroup-class="col-md-4" required>
		<option disabled selected>Select a payment type...</option>
		@foreach ($data['paymentTypes'] as $paymentType)
			<option value="{{$paymentType->id}}" {{$paymentType->id == ($data['payment']->project_payment_type_id ?? 0) ? "selected" : ""}}>{{$paymentType->name}}</option>
		@endforeach
	</x-adminlte-select>

	<x-adminlte-input 
		value="{{$data['payment']->amount ?? ''}}" 
		name="amount" 
		label="Amount" 
		type="number"
		placeholder="Amount"
        fgroup-class="col-md-4" 
		disable-feedback
	/>

	<div class="col-md-4">
	<label for="date">Date</label>
		<input type="date" class="form-control" name="date" id="date" required
				value="{{isset($data['payment']) ? date('Y-m-d', strtotime($data['payment']->date)) : ''}}">
	</div>
	
</div>