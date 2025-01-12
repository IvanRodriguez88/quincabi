@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
	<input type="hidden" id="app_url" value="{{env('APP_URL')}}">
@stop

@section('content')
	<x-adminlte-card>
		<div class="card-header pb-3">
			@if (isset($project))
				<a href="{{route('projects.edit', $project->id)}}">Back</a>
			@endif
			<h2 style="color: #54393a"><b>QuinCabinetry</b></h2>
			<h4 class="text-center">{{$invoice->name}}</h4>
			<div class="d-flex justify-content-between">
				<div>
					<h4>Invoice #{{$invoice->id}}</h4>
					<p class="mb-0">Invoice Date: {{date("m/d/Y", strtotime($invoice->date_issued))}}</p>
					<p class="mb-0">Due Date: {{date("m/d/Y", strtotime($invoice->date_due))}}</p>
				</div>
				<img style="width:60px" src="{{asset('vendor/adminlte/dist/img/logo-black.png')}}" alt="">
			</div>
		</div>
		<div class="card-body">
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
			<table id="material-table" class="table-invoice mt-3">
				<thead>
					<th>Description</th>
					<th>Qty.</th>
					<th class="text-right">Unit Price</th>
					<th class="text-right">Total</th>
				</thead>
				<tbody>
					@foreach ($invoice->invoiceRows as $invoiceRow)
						<tr>
							<td>{{$invoiceRow->name}}</td>
							<td>{{$invoiceRow->amount}}</td>
							<td class="text-right">${{formatNumber($invoiceRow->unit_price)}}</td>
							<td class="total text-right">${{formatNumber($invoiceRow->unit_price * $invoiceRow->amount)}}</td>
						</tr>
					@endforeach
				</tbody>
				
			</table>
			<div class="d-flex justify-content-end mt-3">
				<h4>BALANCE DUE: ${{formatNumber($invoice->getTotal()) ?? ""}}</h4>
			</div>
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
