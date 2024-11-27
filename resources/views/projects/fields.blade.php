<div class="row mb-2">
	<div class="mb-2 col-md-4">
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

<div class="row">

	<x-adminlte-select id="client_id" name="client_id" label="Client" required fgroup-class="col-md-4">
		<option disabled selected>Select a client...</option>
		@foreach ($data["clients"] as $client)
			<option value="{{$client->id}}">{{$client->name}}</option>
		@endforeach
	</x-adminlte-select>

	

	<x-adminlte-input 
		value="{{($data->cost_real) ?? ''}}" 
		name="cost_real" 
		label="Real Cost" 
		placeholder="Real cost of the proyect"
		fgroup-class="col-md-4" 
		disable-feedback
		type="number"
	/>
	<x-adminlte-input 
		value="{{($data->total_real) ?? ''}}" 
		name="total_real" 
		label="Real total price" 
		placeholder="Real total price"
		fgroup-class="col-md-4" 
		disable-feedback
		type="number"
	/>
</div>
<div id="client_info">
</div>	

<script>
	$("#client_id").on("change", function(){
        $.ajax({
            url: `${getBaseUrl()}/projects/getclientinfo/${$(this).val()}`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                $("#client_info").empty().append(response)
            },error: function(xhr, textStatus, errorThrown) {
                errorMessage(xhr.status, errorThrown)
            }
        });
    })
</script>