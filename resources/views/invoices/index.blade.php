@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
	<input type="hidden" id="app_url" value="{{env('APP_URL')}}">
@stop

@section('content')
	<x-adminlte-card>
		<div class="card-header">
			<div class="d-flex justify-content-between">
				<h3>Invoices</h3>
				<a href="{{route('invoices.create')}}" class="btn btn-default bg-teal px-4">
					<i class="fas fa-plus" style="margin-top:6px"></i> Add 
				</a>
			</div>
		</div>
		<div class="card-body">
			<x-adminlte-datatable id="{{$routeResource}}-table" :heads="$heads" striped hoverable with-buttons>
				@foreach($invoices as $invoice)
					<tr>
						<td>{{ $invoice->id }}</td>
						<td>{{ $invoice->client->name }}</td>
						<td>$ {{ number_format($invoice->getCost(), 2, '.', ',') }}</td>
						<td>$ {{ number_format($invoice->getTotal(), 2, '.', ',') }}</td>
						<td>$ {{ number_format($invoice->getProfit(), 2, '.', ',') }}</td>
						<td>{{ date("d/m/Y", strtotime($invoice->date_issued)) }}</td>
						<td>{{ date("d/m/Y", strtotime($invoice->date_due)) }}</td>
						<td>{!! $invoice->is_paid == 1 ? "<span class='badge badge-success p-2 px-3'>Yes</span>" :  "<span class='badge badge-danger p-2 px-3'>No</span>" !!}</td>
						<td class="text-center">
							@include("invoices.buttons")
						</td>
					</tr>
				@endforeach
			</x-adminlte-datatable>
		</div>
	</x-adminlte-card>

	<div id="addEditModal">
		{{-- Aquí se llena el modal por ajax --}}
	</div>
@stop

@section('css')
	@vite(['resources/css/app.css'])
@stop

@section('js')
	@vite(['resources/js/generalFunctions.js', 'resources/js/sweetAlert.js', 'resources/js/invoicesIndex.js'])
@stop
