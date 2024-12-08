@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
	<input type="hidden" id="app_url" value="{{env('APP_URL')}}">
@stop

@section('content')
	<x-adminlte-card>
		<div class="card-header">
			<div class="d-flex justify-content-between">
				<h3>Bills</h3>
				<x-adminlte-button onclick="getAddEditModal('add')" icon="fas fa-plus" label="Add" data-toggle="modal" class="bg-teal px-4"/>
			</div>
		</div>
		<div class="card-body">
			<x-adminlte-datatable id="{{$routeResource}}-table" :heads="$heads" striped hoverable with-buttons>
				@foreach($bills as $bill)
					<tr>
						<td>{{ $bill->id }}</td>
						<td>{{ $bill->billType->name }}</td>
						<td>{{ $bill->projectPaymentType->name }}</td>
						<td>{{ $bill->project->name }}</td>
						<td>{{ $bill->address }}</td>
						<td class="text-center">
							<a class="btn btn-primary" onclick="getAddEditModal('edit', {{$bill->id}})">
								<i class="fas fa-edit"></i>
							</a>
							<a class="btn btn-danger" onclick="showDelete({{$bill->id}}, '{{$bill->description}}')">
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
	@vite(['resources/js/generalFunctions.js', 'resources/js/sweetAlert.js', 'resources/js/clients.js'])
@stop
