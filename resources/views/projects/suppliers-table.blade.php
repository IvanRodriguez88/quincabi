<x-adminlte-card>
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h3>Suppliers</h3>
            <x-adminlte-button onclick="getAddEditModalSupplier('add', {{$project->id}})" icon="fas fa-plus" label="Add" data-toggle="modal" class="bg-teal px-4"/>
        </div>
    </div>
    <div class="card-body">

        <p class="mb-1">Total: <b id="total_suppliers">${{number_format($project->total_suppliers, 4, '.', ',')}}</b></p>

        <hr>
        <x-adminlte-datatable id="project_suppliers-table" :heads="$heads" striped hoverable>
            @foreach($project->suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->pivot->id }}</td>
                    <td>{{ $supplier->name }}</td>
                    <td>$ {{ number_format($supplier->pivot->amount, 4, '.', ',') }}</td>
                    <td class="text-center">
                        <a class="btn btn-primary" onclick="getAddEditModalSupplier('edit', {{$project->id}}, {{$supplier->pivot->id}})">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a class="btn btn-danger" onclick="showDeleteSupplier({{$supplier->pivot->id}}, '{{$supplier->pivot->amount}}')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </div>
</x-adminlte-card>