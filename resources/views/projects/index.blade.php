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
				<a href="{{route('projects.create')}}" class="btn btn-default bg-teal px-4">
					<i class="fas fa-plus" style="margin-top:6px"></i> Add 
				</a>
			</div>
		</div>
		<div class="card-body">
			<x-adminlte-datatable id="{{$routeResource}}-table" :heads="$heads" striped hoverable with-buttons>
				@foreach($projects as $proiect)
					<tr>
						<td>{{ $proiect->id }}</td>
						<td>{{ $proiect->name }}</td>
						<td>{{ $proiect->client->name }}</td>
						<td>{{ $proiect->cost_real }}</td>
						<td>{{ $proiect->total_real }}</td>
						<td>{{ $proiect->profit }}</td>
						<td class="text-center">
							@include("projects.buttons")
						</td>
					</tr>
				@endforeach
			</x-adminlte-datatable>
		</div>
	</x-adminlte-card>
@stop

@section('css')
	@vite(['resources/css/app.css'])
@stop

@section('js')
	@vite(['resources/js/generalFunctions.js', 'resources/js/sweetAlert.js', 'resources/js/invoicesIndex.js'])
@stop
