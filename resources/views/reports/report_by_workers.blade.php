@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
	<input type="hidden" id="app_url" value="{{env('APP_URL')}}">
@stop

@section('content')
	<x-adminlte-card>
		<div class="card-header">
			<div class="d-flex justify-content-between">
				<h3>Report by workers</h3>
			</div>
		</div>
		<div class="card-body">
			<div class="d-flex justify-content-center">
				<div class="col-md-8">
					<div class="accordion" id="accordionExample">
						<div class="card">
							  <div class="card-header" id="headingOne">
								<h2 class="mb-0">
								<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
									Filters
								</button>
								</h2>
							  </div>
					  
							  <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
								<div class="card-body">
									<form id="filterForm">
										<div class="row">
											<x-adminlte-input 
												name="start_date" 
												label="Initial Date" 
												fgroup-class="col-md-4" 
												disable-feedback
												type="date"
											/>
											<x-adminlte-input 
												name="end_date" 
												label="End Date" 
												fgroup-class="col-md-4" 
												disable-feedback
												type="date"
											/>	
											<x-adminlte-select id="worker_id" name="worker_id" label="Workers" fgroup-class="col-md-4">
												<option value="0" selected>All</option>
												@foreach ($workers as $workers)
													<option value="{{$workers->id}}">{{$workers->name}}</option>
												@endforeach
											</x-adminlte-select>
										</div>
										<div class="d-flex justify-content-end">
											<a class="btn btn-secondary" id="filterButton">Filter</a>
										</div>
									</form>
								</div>
							  </div>
						</div>
					</div>
				</div>
			</div>
			

			<x-adminlte-datatable id="{{$routeResource}}-table" :heads="$heads" striped hoverable with-buttons>
				@foreach($data as $row)
					<tr>
						<td>{{ $row['worker'] }}</td>
						<td>{{ $row['worked_hours'] }}</td>
						<td>${{ $row['amount'] }}</td>
					</tr>
				@endforeach
			</x-adminlte-datatable>
		</div>

		<hr>
		<figure class="highcharts-figure">
			<div id="container"></div>
		</figure>
	</x-adminlte-card>
	
@stop

@section('css')
	@vite(['resources/css/app.css'])
@stop

@section('js')
	@vite(['resources/js/generalFunctions.js', 'resources/js/sweetAlert.js', 'resources/js/report_by_workers.js'])
@stop
