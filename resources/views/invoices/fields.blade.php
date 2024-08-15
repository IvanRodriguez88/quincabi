<div class="row">
	@if (isset($invoice))
		<x-adminlte-select id="client_id" name="client_id" label="Client" fgroup-class="col-md-4" required>
			<option disabled>Select a client...</option>
			@foreach ($clients as $client)
				<option value="{{$client->id}}" {{$client->id == $invoice->client_id ? "selected" : ""}}>{{$client->name}}</option>
			@endforeach
		</x-adminlte-select>
	@else
		<x-adminlte-select id="client_id" name="client_id" label="Client" fgroup-class="col-md-4" required>
			<option disabled selected>Select a client...</option>
			@foreach ($clients as $client)
				<option value="{{$client->id}}">{{$client->name}}</option>
			@endforeach
		</x-adminlte-select>
	@endif

	<div class="col-md-4">
		<label for="date_issued">Date issued</label>
		<input type="text" class="form-control" name="date_issued" id="date_issued" readonly
				value="{{isset($invoice) ? date('d/m/Y', strtotime($invoice->date_issued)) : date('d/m/Y', strtotime(now()))}}">
	</div>
	<div class="col-md-4">
		<label for="date_due">Due date</label>
		<input type="date" class="form-control" name="date_due" id="date_due" required
				value="{{isset($invoice) ? date('Y-m-d', strtotime($invoice->date_due)) : ''}}">
	</div>
</div>

<div id="client_info">
	@if (isset($invoice))
		{!! $clientInfo !!}
	@endif
</div>

<hr>
<form id="material-form">
	<div class="row">
		<div class="col-md-5">
			<label for="material_name">Material name</label><br>
			<input id="material_name" class="form-control" name="material_name">
			<input type="hidden" name="material_id" id="material_id">
		</div>

		<x-adminlte-input 
			value="1" 
			name="amount" 
			label="Amount" 
			type="number" 
			placeholder="Amount"
			fgroup-class="col-md-2" 
			disable-feedback
			min=1
		/>

		<x-adminlte-input 
			value="" 
			name="unit_price" 
			label="Unit price" 
			type="number" 
			placeholder="Unit price"
			fgroup-class="col-md-2" 
			disable-feedback
			min=1
		/>

		<x-adminlte-input 
			value="" 
			name="total_price" 
			label="Total" 
			type="number" 
			placeholder="Total"
			fgroup-class="col-md-2" 
			disable-feedback
			disabled
		/>

		<div class="col-1">
			<button onclick="addMaterial()" type="button" class="btn btn-primary" style="margin-top: 30px">Agregar</button>
		</div>
	</div>
</form>

<table id="material-table" class="table-invoice">
	<thead>
		<th>Material</th>
		<th>Qty.</th>
		<th>Unit Price</th>
		<th>Total</th>
		<th></th>
	</thead>
	<tbody>
		@if (isset($invoice))
			@foreach ($invoice->invoiceRows as $invoiceRow)
				@include("invoices.material-row", [
					"uniqueId" => uniqid(),
					"material" => $invoiceRow->material,
					"amount" => $invoiceRow->amount,
					"unit_price" => $invoiceRow->unit_price,
					"total" => $invoiceRow->unit_price * $invoiceRow->amount,
				])
			@endforeach
		@endif
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3"></td>
			<td><b id="total_invoice" style="font-size:18px">${{number_format($invoice->getTotal(), 2, '.', ',') ?? ""}}</b></td>
		</tr>
	</tfoot>
</table>

