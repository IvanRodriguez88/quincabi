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
						<td>{{ $invoice->date_issued }}</td>
						<td>{{ $invoice->date_due }}</td>
						<td>{{ $invoice->is_paid }}</td>
						<td class="text-center">
							<a class="btn btn-primary" href="{{route('invoices.edit', $invoice->id)}}">
								<i class="fas fa-edit"></i>
							</a>
							<a class="btn btn-danger" onclick="showDelete({{$invoice->id}}, '{{$invoice->name}}')">
								<i class="fas fa-trash"></i>
							</a>
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
	@vite(['resources/js/generalFunctions.js', 'resources/js/sweetAlert.js'])
@stop
