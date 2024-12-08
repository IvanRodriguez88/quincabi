@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
	<input type="hidden" id="app_url" value="{{env('APP_URL')}}">
@stop

@section('content')
	<x-adminlte-card>
		<div class="card-header">
			<div class="d-flex justify-content-between">
				<h3>Bill Types</h3>
				<x-adminlte-button onclick="getAddEditModal('add')" icon="fas fa-plus" label="Add" data-toggle="modal" class="bg-teal px-4"/>
			</div>
		</div>
		<div class="card-body">
			<x-adminlte-datatable id="{{$routeResource}}-table" :heads="$heads" striped hoverable with-buttons>
				@foreach($bill_types as $bill_type)
					<tr>
						<td>{{ $bill_type->id }}</td>
						<td>{{ $bill_type->name }}</td>
						<td class="text-center">
							<a class="btn btn-primary" onclick="getAddEditModal('edit', {{$bill_type->id}})">
								<i class="fas fa-edit"></i>
							</a>
							<a class="btn btn-danger" onclick="showDelete({{$bill_type->id}}, '{{$bill_type->name}}')">
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
	@vite(['resources/js/generalFunctions.js', 'resources/js/sweetAlert.js', 'resources/js/bill_types.js'])
@stop
