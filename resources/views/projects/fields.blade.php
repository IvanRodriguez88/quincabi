<div class="row mb-2">
	<div class="col-md-4">
		<label for="name">Project name</label>
		<input type="text" class="form-control" name="name" id="name"
				value="{{ $project->name ?? '' }} ">
	</div>
	<div class="col-md-4">
		<label for="initial_date">Initial date</label>
		<input type="date" class="form-control" name="initial_date" id="initial_date" required
				value="{{isset($project) ? date('Y-m-d', strtotime($project->initial_date)) : ''}}">
	</div>
	<div class="col-md-4">
		<label for="end_date">End date</label>
		<input type="date" class="form-control" name="end_date" id="end_date" required
				value="{{isset($project) ? date('Y-m-d', strtotime($project->end_date)) : ''}}">
	</div>
</div>

@if (isset($project))
	<x-adminlte-select id="client_id" name="client_id" label="Client" fgroup-class="col-md-4 p-0" required>
		<option disabled>Select a client...</option>
		@foreach ($clients as $client)
			<option value="{{$client->id}}" {{$client->id == $project->client_id ? "selected" : ""}}>{{$client->name}}</option>
		@endforeach
	</x-adminlte-select>
@else
	<x-adminlte-select id="client_id" name="client_id" label="Client" fgroup-class="col-md-4 p-0" required>
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