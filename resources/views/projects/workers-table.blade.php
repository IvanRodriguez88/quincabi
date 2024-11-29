<x-adminlte-card>
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h3>Workers</h3>
            <a onclick="getAddEditModal('add', {{$project->id}})" class="btn btn-default bg-teal px-4">
                <i class="fas fa-plus" style="margin-top:6px"></i> Add 
            </a>
        </div>
    </div>
    <div class="card-body">
        <x-adminlte-datatable id="{{$routeResource}}-table" :heads="$heads" striped hoverable>
            @foreach($project->workers as $worker)
                <tr>
                    <td>{{$worker->pivot->id}}</td>
                    <td>{{ $worker->name }}</td>
                    <td>${{ number_format($worker->pivot->hourly_pay, 2, ".", ",") }}</td>
                    <td>${{ number_format($worker->pivot->worked_hours, 2, ".", ",") }}</td>
                    <td>${{ number_format($worker->pivot->hourly_pay * $worker->pivot->worked_hours, 2, ".", ",") }}</td>
                    <td class="text-center">
                        <div class="text-center">
                            <a class="btn btn-primary" onclick="getAddEditModal('edit', {{$project->id}}, {{$worker->pivot->id}})">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a class="btn btn-danger" onclick="showDeleteWorker({{$worker->pivot->id}}, '{{$worker->name}}')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </div>
</x-adminlte-card>