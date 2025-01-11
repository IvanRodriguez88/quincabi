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
		<p class="mb-1">Total Worked Hours: <b id="total_worked_hours">{{$project->total_worked_hours}}</b></p>
        <p class="mb-1">Total payments: <b id="total_payments_workers">${{number_format($project->total_payments_workers, 4, '.', ',')}}</b></p>
        <p class="mb-1">Average payment per hour: <b id="average_payment_per_hour">${{number_format($project->average_payment_per_hour, 4, '.', ',')}}</b></p>

		<hr>
        <x-adminlte-datatable id="{{$routeResource}}-table" :heads="$heads" striped hoverable>
            @foreach($project->workers as $worker)
                <tr>
                    <td>{{$worker->pivot->id}}</td>
                    <td>{{ $worker->name }}</td>
                    <td>{{ $worker->pivot->date != null ? date("m/d/Y", strtotime($worker->pivot->date)) : ""  }}</td>
                    <td>${{ number_format($worker->pivot->hourly_pay, 4, ".", ",") }}</td>
                    <td>{{$worker->pivot->worked_hours}}</td>
                    <td>${{ number_format($worker->pivot->hourly_pay * $worker->pivot->worked_hours, 4, ".", ",") }}</td>
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