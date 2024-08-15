@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
	<input type="hidden" id="app_url" value="{{env('APP_URL')}}">
@stop

@section('content')
	<x-adminlte-card>
		<div class="card-header">
			<div class="d-flex justify-content-between">
				<div>
					<h3>Invoice #{{$invoice->id}}</h3>
					<p class="mb-0">Invoice Date: {{date("d/m/Y", strtotime($invoice->date_issued))}}</p>
					<p class="mb-0">Due Date: {{date("d/m/Y", strtotime($invoice->date_due))}}</p>
				</div>
				<img src="" alt="" srcset="">
			</div>
		</div>
		<div class="card-body ">
			<div class="d-flex justify-content-between">
				<div>
					<p class="mb-0">916 Woodland St Channelview, TX 77530</p>
					<p class="mb-0">quincabinetry.com</p>
					<p class="mb-0">(832) 530-8388</p>
				</div>
				<div>
					<p class="mb-0"><b>BILL TO</b></p>
					<p class="mb-0">{{$invoice->client->name}}</p>
					<p class="mb-0">{{$invoice->client->address}}</p>
					<p class="mb-0">{{$invoice->client->phone}}</p>
					<p class="mb-0">{{$invoice->client->email}}</p>
				</div>
			</div>
			<hr>
			<h4>Materials</h4>
			<table id="material-table" class="table-invoice mt-3">
				<thead>
					<th>Material</th>
					<th>Qty.</th>
					<th>Unit Price</th>
					<th>Total</th>
				</thead>
				<tbody>
					@foreach ($invoice->invoiceRows as $invoiceRow)
						<tr>
							<td>{{$invoiceRow->material->name}}</td>
							<td>{{$invoiceRow->amount}}</td>
							<td>${{number_format($invoiceRow->unit_price, 2, '.', ',')}}</td>
							<td class="total">${{number_format($invoiceRow->unit_price * $invoiceRow->amount, 2, '.', ',')}}</td>
						</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3"></td>
						<td><b id="total_invoice" style="font-size:18px">${{number_format($invoice->getTotal(), 2, '.', ',') ?? ""}}</b></td>
					</tr>
				</tfoot>
			</table>
			<p class="mt-2 text-center">Thank you for your business!</p>
		</div>
	
	</x-adminlte-card>

@stop

@section('css')
	@vite(['resources/css/app.css'])
	@vite(['resources/sass/invoices.scss'])

@stop

@section('js')
@stop
