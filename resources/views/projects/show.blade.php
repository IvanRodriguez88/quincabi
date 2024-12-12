@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
	<input type="hidden" id="app_url" value="{{env('APP_URL')}}">
@stop

@section('content')
	<x-adminlte-card>
		<div class="card-header pb-3">
			@if (isset($project))
				<a href="{{route('projects.index')}}">Back</a>
			@endif
			<h2 style="color: #54393a"><b>QuinCabinetry</b></h2>
			<h4 class="text-center">Project: {{$project->name}}</h4>
			<div class="d-flex justify-content-between">
				<div>
					<h4>Project #{{$project->id}}</h4>
					<p class="mb-0">Initial Date: {{isset($project->initial_date) ? date("m/d/Y", strtotime($project->initial_date)) : "-"}}</p>
					<p class="mb-0">End Date: {{isset($project->end_date) ? date("m/d/Y", strtotime($project->end_date)) : "-"}}</p>
				</div>
				<img style="width:60px" src="{{asset('vendor/adminlte/dist/img/logo-black.png')}}" alt="">
			</div>
		</div>
		<div class="card-body">
			<div class="d-flex justify-content-between">
				<div>
					<p class="mb-0">916 Woodland St Channelview, TX 77530</p>
					<p class="mb-0">quincabinetry.com</p>
					<p class="mb-0">(832) 530-8388</p>
					<p class="mb-0 mt-2">Cost: {{number_format($project->real_cost, 2, ".", ",")}}</p>
					<p class="mb-0">Price: {{number_format($project->real_total, 2, ".", ",")}}</p>
				</div>
				<div>
					<p class="mb-0"><b>BILL TO</b></p>
					<p class="mb-0">{{$project->client->name}}</p>
					<p class="mb-0">{{$project->client->address}}</p>
					<p class="mb-0">{{$project->client->phone}}</p>
					<p class="mb-0">{{$project->client->email}}</p>
				</div>
			</div>
			<hr>
			<h5>Description of the project</h5>
			{!! $project->description !!}
			<hr>
		</div>
	
	</x-adminlte-card>

@stop

@section('css')
	@vite(['resources/css/app.css'])
	@vite(['resources/sass/invoices.scss'])
@stop

@section('js')
@stop
