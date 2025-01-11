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
			<form id="project-form" action="{{route('projects.update', $project->id)}}" method="POST" enctype="multipart/form-data">
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
							<div class="col-md-6">
								<x-adminlte-input 
									value="{{$project->total_cost}}" 
									name="cost_real" 
									label="Real Cost" 
									placeholder="Real cost of the proyect"
									fgroup-class="mb-1" 
									disable-feedback
									type="number"
									readonly
								/>
								<p >Proyected cost <b id="cost_proyected">${{number_format($project->totalInvoicesCosts() ?? 0, 4, ".", ",")}}</b></p>
							</div>
							<x-adminlte-input 
								value="{{($project->total_real == $project->totalInvoicesPrices() ? $project->total_real : $project->totalInvoicesPrices())}}" 
								name="total_real" 
								label="Real total price" 
								placeholder="Real total price"
								fgroup-class="col-md-6" 
								disable-feedback
								type="number"
								readonly
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

				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Invoices</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Workers</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="contact-tab" data-toggle="tab" data-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Payments</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="bills-tab" data-toggle="tab" data-target="#bills" type="button" role="tab" aria-controls="bills" aria-selected="false">Bills</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="partners-tab" data-toggle="tab" data-target="#partners" type="button" role="tab" aria-controls="partners" aria-selected="false">Partners</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="suppliers-tab" data-toggle="tab" data-target="#suppliers" type="button" role="tab" aria-controls="suppliers" aria-selected="false">Suppliers</button>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">{!! $invoicesTable !!}</div>
					<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">{!! $workersTable !!}</div>
					<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">{!! $paymentsTable !!}</div>
					<div class="tab-pane fade" id="bills" role="tabpanel" aria-labelledby="bills-tab">{!! $billsTable !!}</div>
					<div class="tab-pane fade" id="partners" role="tabpanel" aria-labelledby="partners-tab">{!! $partnersTable !!}</div>
					<div class="tab-pane fade" id="suppliers" role="tabpanel" aria-labelledby="suppliers-tab">{!! $suppliersTable !!}</div>

				</div>

				<hr>

				<div class="row">
					<div class="col-md-6">
						<h3>Project Images</h3>
						<x-adminlte-input-file id="upload-project-picture" name="images[]" label="Cargar imagen de Proyecto" placeholder="Seleccionar imagen" legend="Seleccionar" igroup-size="md" accept="image/*" />
						<div id="image-preview" style="display: flex; flex-wrap: wrap;">

							@foreach ($project->projectPictures as $picture)
								@include("projects.image", [
									"src" => $picture->path,
									"filename" => $picture->filename(),
									"picture_id" => $picture->id
								])
							@endforeach

						</div>
					</div>
					<div class="col-md-6">
						<h3>Project Tickets</h3>
						<x-adminlte-input-file id="upload-project-ticket" name="images[]" label="Cargar ticket" placeholder="Seleccionar imagen" legend="Seleccionar" igroup-size="md" accept="image/*" />
						<div id="image-ticket-preview" style="display: flex; flex-wrap: wrap;">
							@foreach ($project->projectTickets as $ticket)
								@include("projects.ticket", [
									"src" => $ticket->path,
									"filename" => $ticket->filename(),
									"ticket_id" => $ticket->id
								])
							@endforeach
						</div>
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
	@vite(['resources/sass/projects.scss'])

@stop

@section('js')
	<script src="{{asset('plugins/autocomplete/autoComplete.min.js')}}"></script>
	@vite(['resources/js/tinymce.js', 'resources/js/generalFunctions.js', 'resources/js/sweetAlert.js', 'resources/js/autocomplete.js', 'resources/js/projects.js'])
@stop
