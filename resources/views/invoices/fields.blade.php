<div class="row">
	<div class="col-md-4">
		<label for="date_issued">Name (shown in invoice)</label>
		<input type="text" class="form-control" name="name" id="name"
				value="{{ $invoice->name ?? '' }} ">
	</div>
	<div class="col-md-4">
		<label for="date_issued">Date issued</label>
		<input type="text" class="form-control" name="date_issued" id="date_issued" readonly
				value="{{isset($invoice) ? date('m/d/Y', strtotime($invoice->date_issued)) : date('m/d/Y', strtotime(now()))}}">
	</div>
	<div class="col-md-4">
		<label for="date_due">Due date</label>
		<input type="date" class="form-control" name="date_due" id="date_due" required
				value="{{isset($invoice) ? date('Y-m-d', strtotime($invoice->date_due)) : ''}}">
	</div>
</div>


@if (isset($project))
	<input type="hidden" name="client_id" id="client_id" value="{{$project->client->id}}">
	<div class="card p-2 mt-2">
		<p class="m-0"><b>Name: </b> {{$project->client->name}}</p>
		<p class="m-0"><b>Phone: </b> {{$project->client->phone ?? ""}}</p>
		<p class="m-0"><b>Address: </b> {{$project->client->address ?? ""}}</p>
		<p class="m-0"><b>Email: </b> {{$project->client->email ?? ""}}</p>
	</div>
@else
	<div class="row mt-2">
		@if (isset($invoice))
			<x-adminlte-select id="client_id" name="client_id" label="Client" required fgroup-class="col-md-4">
				<option disabled>Select a client...</option>
				@foreach ($clients as $client)
					<option value="{{$client->id}}" {{$invoice->client_id == $client->id ? "selected" : ""}}>{{$client->name}}</option>
				@endforeach
			</x-adminlte-select>	
			<div class="col-8">
				<div id="client_info">
					{!! $clientInfo !!}
				</div>
			</div>
		@else
			<x-adminlte-select id="client_id" name="client_id" label="Client" required fgroup-class="col-md-4">
				<option disabled selected>Select a client...</option>
				@foreach ($clients as $client)
					<option value="{{$client->id}}">{{$client->name}}</option>
				@endforeach
			</x-adminlte-select>	
			<div class="col-8">
				<div id="client_info">
				</div>
			</div>
		@endif
	</div>
@endif


<hr>
<form id="material-form">
	<div>
		<input id="free_check" type="checkbox">
		<label for="free_check" class="me-2">Free name</label>
	</div>
	<div class="row">
		<div class="col-md-4">
			<div id="search_material">
				<label for="material_name">Material name</label><br>
				<input id="material_name" class="form-control" name="material_name">
				<input type="hidden" name="material_id" id="material_id">
			</div>
			<div id="free_material" class="d-none">
				<x-adminlte-input 
					name="free_material_input" 
					label="Name" 
					type="text" 
					placeholder="Name"
					disable-feedback
					min=1
				/>
			</div>
		</div>

		<x-adminlte-input 
			value="1" 
			name="amount" 
			label="Amount" 
			type="number" 
			placeholder="Amount"
			fgroup-class="col-md-1" 
			disable-feedback
			min=1
		/>

		<x-adminlte-input 
			value="" 
			name="unit_cost" 
			label="Unit cost" 
			type="number" 
			placeholder="Unit cost"
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
		<th>Description</th>
		<th>Qty.</th>		
		<th>Unit Cost</th>
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
					"free_material" => $invoiceRow->name,
					"amount" => $invoiceRow->amount,
					"unit_cost" => $invoiceRow->unit_cost,
					"unit_price" => $invoiceRow->unit_price,
					"total" => $invoiceRow->unit_price * $invoiceRow->amount,
				])
			@endforeach
		@endif
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3"></td>
			@if (isset($invoice))
				<td><b id="total_invoice" style="font-size:18px">${{number_format($invoice->getTotal(), 2, '.', ',')}}</b></td>
			@else
				<td><b id="total_invoice" style="font-size:18px">${{number_format(0, 2, '.', ',')}}</b></td>
			@endif

		</tr>
	</tfoot>
</table>

