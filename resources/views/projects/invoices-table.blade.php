<x-adminlte-card>
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h3>Invoices</h3>
            <div>
                <a onclick="addExistingInvoiceModal({{$project->id}})" class="btn btn-default bg-primary px-4">
                    <i class="fas fa-plus" style="margin-top:6px"></i> Add an existing invoice
                </a>
                <a href="{{route('invoices.createInProject', $project->id)}}" class="btn btn-default bg-teal px-4">
                    <i class="fas fa-plus" style="margin-top:6px"></i> Add new
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <x-adminlte-datatable id="{{$routeResource}}-table" :heads="$heads" striped hoverable>
            @foreach($project->invoices as $invoice)
                <tr>
                    <td>{{ $invoice->id }}</td>
                    <td>{{ $invoice->name }}</td>
					<td>$ {{ number_format($invoice->getCost(), 4, '.', ',') }}</td>
					<td>$ {{ number_format($invoice->getTotal(), 4, '.', ',') }}</td>
                    <td>{{ date("m/d/Y", strtotime($invoice->date_due)) }}</td>
					<td>{!! $invoice->in_use ? "<span class='badge badge-success'>Yes</span>" : "<span class='badge badge-danger'>No</span>"!!}</td>
                    <td>
                        @include("invoices.buttons")
                    </td>
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </div>
</x-adminlte-card>