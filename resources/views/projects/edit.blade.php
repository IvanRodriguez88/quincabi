@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
	<input type="hidden" id="app_url" value="{{env('APP_URL')}}">
@stop

@section('content')
	<input type="hidden" id="type" value="create">
	<input type="hidden" id="project_id" value="{{$project->id}}">

	<div id="error-messages">

	</div>
	<x-adminlte-card>
		<div class="card-header">
			<div class="d-flex justify-content-between">
				<h3>Edit Project</h3>
			</div>
		</div>
		<div class="card-body">
			<form id="project-form" action="{{route('projects.update', $project->id)}}" method="POST">
				@method('put')
				@csrf
				<div class="row">
					<div class="col-md-4">
						@if (isset($project))
							<x-adminlte-select id="client_id" name="client_id" label="Client" required>
								<option disabled>Select a client...</option>
								@foreach ($clients as $client)
									<option value="{{$client->id}}" {{$client->id == $project->client_id ? "selected" : ""}}>{{$client->name}}</option>
								@endforeach
							</x-adminlte-select>
						@else
							<x-adminlte-select id="client_id" name="client_id" label="Client" required>
								<option disabled selected>Select a client...</option>
								@foreach ($clients as $client)
									<option value="{{$client->id}}">{{$client->name}}</option>
								@endforeach
							</x-adminlte-select>
						@endif

						<div id="client_info">
							@if (isset($project))
								{!! $clientInfo !!}
							@endif
						</div>
						<div class="mb-2">
							<x-adminlte-input 
								value="{{($project->name) ?? ''}}" 
								name="name" 
								label="Name" 
								placeholder="Project name"
								disable-feedback
								type="text"
							/>
						</div>
						<div class="row mb-2">
							<div class="col-md-6">
								<label for="initial_date">Initial date</label>
								<input type="date" class="form-control" name="initial_date" id="initial_date" required
										value="{{isset($project) ? date('Y-m-d', strtotime($project->initial_date)) : ''}}">
							</div>
							<div class="col-md-6">
								<label for="end_date">End date</label>
								<input type="date" class="form-control" name="end_date" id="end_date" required
										value="{{isset($project) ? date('Y-m-d', strtotime($project->end_date)) : ''}}">
							</div>
						</div>
						<div class="row">
							<x-adminlte-input 
								value="{{($project->cost_real) ?? ''}}" 
								name="cost_real" 
								label="Real Cost" 
								placeholder="Real cost of the proyect"
								fgroup-class="col-md-6" 
								disable-feedback
								type="number"
							/>
							<x-adminlte-input 
								value="{{($project->total_real) ?? ''}}" 
								name="total_real" 
								label="Real total price" 
								placeholder="Real total price"
								fgroup-class="col-md-6" 
								disable-feedback
								type="number"
							/>
						</div>


					</div>
					<div class="col-md-8">
						<label>Description of the project</label>
						<textarea name="description" id="description">
							{{ $project->description }}
						</textarea>
					</div>
				</div>

				<hr>
				<div class="row">
					<div class="col-md-6">
						{!! $invoicesTable !!}
					</div>
					<div class="col-md-6">
						{!! $workersTable !!}
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						{!! $paymentsTable !!}
					</div>
				</div>

				<div class="d-flex mt-3 justify-content-end">
					<x-adminlte-button type="submit"  theme="success" label="Save Project"/>
				</div>
			</form>
		</div>
	</x-adminlte-card>

	<div id="addEditModal">
		{{-- Aquí se llena el modal por ajax --}}
	</div>
	
@stop

@section('css')
	<link rel="stylesheet" href="{{asset('plugins/autocomplete/css/autoComplete.02.css')}}">
	@vite(['resources/css/app.css'])

@stop

@section('js')
	<script src="{{asset('plugins/autocomplete/autoComplete.min.js')}}"></script>
	@vite(['resources/js/tinymce.js', 'resources/js/generalFunctions.js', 'resources/js/sweetAlert.js', 'resources/js/autocomplete.js', 'resources/js/projects.js'])
@stop
