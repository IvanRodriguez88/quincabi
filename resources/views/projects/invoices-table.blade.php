<x-adminlte-card>
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h3>Invoices</h3>
            <a href="{{route('invoices.createInProject', $project->id)}}" class="btn btn-default bg-teal px-4">
                <i class="fas fa-plus" style="margin-top:6px"></i> Add 
            </a>
        </div>
    </div>
    <div class="card-body">
        <x-adminlte-datatable id="{{$routeResource}}-table" :heads="$heads" striped hoverable>
            @foreach($project->invoices as $invoice)
                <tr>
                    <td>{{ $invoice->id }}</td>
                    <td>{{ $invoice->name }}</td>
                    <td>{{ date("m/d/Y", strtotime($invoice->date_due)) }}</td>
                    <td class="text-center">
                        @include("invoices.buttons")
                    </td>
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </div>
</x-adminlte-card>