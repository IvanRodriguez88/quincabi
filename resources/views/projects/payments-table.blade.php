<x-adminlte-card>
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h3>Payments</h3>
            <x-adminlte-button onclick="getAddEditModalPayment('add', {{$project->id}})" icon="fas fa-plus" label="Add" data-toggle="modal" class="bg-teal px-4"/>
        </div>
    </div>
    <div class="card-body">

        <p class="mb-1">Total:</b></p>
        <p class="mb-1">Total payments: <b>${{number_format($project->getTotalPayments(), 2, '.', ',')}}</b></p>
        <p class="mb-1">Rest: </b></p>

        <hr>
        <x-adminlte-datatable id="project_payments-table" :heads="$heads" striped hoverable>
            @foreach($project->payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->projectPaymentType->name }}</td>
                    <td>$ {{ number_format($payment->amount, 2, '.', ',') }}</td>
                    <td>{{ date("d/m/Y", strtotime($payment->date)) }}</td>
                    <td class="text-center">
                        <a class="btn btn-primary" onclick="getAddEditModalPayment('edit', {{$project->id}}, {{$payment->id}})">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a class="btn btn-danger" onclick="showDelete({{$payment->id}}, '{{$payment->amount}}')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </div>
</x-adminlte-card>