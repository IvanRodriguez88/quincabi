@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
	<input type="hidden" id="app_url" value="{{env('APP_URL')}}">
@stop

@section('content')
	<x-adminlte-card>
		<div class="card-header">
			<div class="d-flex justify-content-between">
				<h3>Projects</h3>
				<x-adminlte-button onclick="getAddEditModal('add')" icon="fas fa-plus" label="Add" data-toggle="modal" class="bg-teal px-4"/>
			</div>
		</div>
		<div class="card-body">
			<x-adminlte-datatable id="{{$routeResource}}-table" :heads="$heads" striped hoverable with-buttons>
				@foreach($projects as $project)
					<tr>
						<td>{{ $project->id }}</td>
						<td>{{ $project->name }}</td>
						<td>{{ $project->client->name }}</td>
						<td>{{ $project->cost_real }}</td>
						<td>{{ $project->total_real }}</td>
						<td>{{ $project->profit }}</td>
						<td class="text-center">
							@include("projects.buttons")
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
	@vite(['resources/js/generalFunctions.js', 'resources/js/sweetAlert.js', 'resources/js/projectsIndex.js'])
@stop
