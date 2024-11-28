<x-adminlte-card>
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h3>Workers</h3>
            <a onclick="getAddEditModal('add')" class="btn btn-default bg-teal px-4">
                <i class="fas fa-plus" style="margin-top:6px"></i> Add 
            </a>
        </div>
    </div>
    <div class="card-body">
        <x-adminlte-datatable id="{{$routeResource}}-table" :heads="$heads" striped hoverable>
            @foreach($project->workers as $worker)
                <tr>
                    <td>{{ $worker->id }}</td>
                    <td>{{ $worker->name }}</td>
                    <td class="text-center">
                       
                    </td>
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </div>
</x-adminlte-card>