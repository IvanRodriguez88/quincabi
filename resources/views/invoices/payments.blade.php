@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
	<input type="hidden" id="app_url" value="{{env('APP_URL')}}">
@stop

@section('content')
	<input type="hidden" id="invoice_id" value="{{$invoice->id}}">

	<x-adminlte-card>
		<div class="card-header">
			<div class="d-flex justify-content-between">
				<h3>Payments</h3>
				<x-adminlte-button onclick="getAddEditModal({{$invoice->id}},'add')" icon="fas fa-plus" label="Add" data-toggle="modal" class="bg-teal px-4"/>
			</div>
		</div>
		<div class="card-body">
            <h4>Invoice #{{$invoice->id}}</h4>

            <p class="mb-1">Total: <b>${{number_format($invoice->getTotal(), 2, '.', ',')}}</b></p>
            <p class="mb-1">Total payments: <b>${{number_format($invoice->getTotalPayments(), 2, '.', ',')}}</b></p>
            <p class="mb-1">Rest: <b>${{number_format($invoice->getTotal() - $invoice->getTotalPayments() , 2, '.', ',')}}</b></p>

            <hr>
            <x-adminlte-datatable id="payments-table" :heads="$heads" striped hoverable with-buttons>
				@foreach($invoice->invoicePayments as $payment)
					<tr>
						<td>{{ $payment->id }}</td>
						<td>{{ $payment->invoicePaymentType->name }}</td>
						<td>$ {{ number_format($payment->amount, 2, '.', ',') }}</td>
						<td>{{ date("d/m/Y", strtotime($payment->date)) }}</td>
                        <td class="text-center">
							<a class="btn btn-primary" onclick="getAddEditModal({{$invoice->id}}, 'edit', {{$payment->id}})">
								<i class="fas fa-edit"></i>
							</a>
							<a class="btn btn-danger" onclick="showDelete({{$payment->id}}, '{{$payment->amount}}')">
								<i class="fas fa-trash"></i>
							</a>
						</td>
					</tr>
				@endforeach
			</x-adminlte-datatable>

			<div class="d-flex mt-3 justify-content-end">
				<a href="{{route('invoices.index')}}" class="btn btn-dark px-2">Go back</a>
			</div>
		</div>
	</x-adminlte-card>
    <div id="addEditModal">
		{{-- Aquí se llena el modal por ajax --}}
	</div>
@stop

@section('css')
	<link rel="stylesheet" href="{{asset('plugins/autocomplete/css/autoComplete.02.css')}}">
	@vite(['resources/css/app.css'])
	@vite(['resources/sass/invoices.scss'])

@stop

@section('js')
	<script src="{{asset('plugins/autocomplete/autoComplete.min.js')}}"></script>
	@vite(['resources/js/generalFunctions.js', 'resources/js/sweetAlert.js', 'resources/js/autocomplete.js', 'resources/js/payments.js'])
@stop
