@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
	<input type="hidden" id="app_url" value="{{env('APP_URL')}}">
@stop

@section('content')
	<input type="hidden" id="invoice_id" value="{{$invoice->id}}">
	<input type="hidden" id="type" value="edit">
	<input type="hidden" id="project_id" value="{{$project->id ?? ''}}">

	<div id="error-messages">

	</div>
	<x-adminlte-card>
		<div class="card-header">
			<div class="d-flex justify-content-between">
				@if (isset($project))
					<h3>Edit invoice for project - <b>{{$project->name}}</b></h3>
					<a href="{{route('projects.edit', $project->id)}}">Back</a>
				@else
					<h3>Edit invoice</h3>
				@endif
			</div>
		</div>
		<div class="card-body">
            <h4>Invoice #{{$invoice->id}}</h4>
			@include("invoices.fields")
			<div class="d-flex mt-3 justify-content-end">
				<x-adminlte-button onclick="saveInvoice()"  theme="success" label="Save Invoice"/>
			</div>
		</div>
	</x-adminlte-card>

@stop

@section('css')
	<link rel="stylesheet" href="{{asset('plugins/autocomplete/css/autoComplete.02.css')}}">
	@vite(['resources/css/app.css'])
	@vite(['resources/sass/invoices.scss'])

@stop

@section('js')
	<script src="{{asset('plugins/autocomplete/autoComplete.min.js')}}"></script>
	@vite(['resources/js/generalFunctions.js', 'resources/js/sweetAlert.js', 'resources/js/autocomplete.js', 'resources/js/invoices.js'])
@stop
