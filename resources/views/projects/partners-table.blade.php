<x-adminlte-card>
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h3>Partners</h3>
            <a onclick="getAddEditModalPartner('add', {{$project->id}})" class="btn btn-default bg-teal px-4">
                <i class="fas fa-plus" style="margin-top:6px"></i> Add 
            </a>
        </div>
    </div>
    <div class="card-body">
		<hr>
        <x-adminlte-datatable id="{{$routeResource}}-table" :heads="$heads" striped hoverable>
            @foreach($project->partners as $partner)
                <tr>
                    <td>{{$partner->pivot->id}}</td>
                    <td>{{ $partner->name }}</td>
                    <td>{{ $partner->pivot->percentage }}%</td>
                    <td class="text-center">
                        <div class="text-center">
                            <a class="btn btn-primary" onclick="getAddEditModalPartner('edit', {{$project->id}}, {{$partner->pivot->id}})">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a class="btn btn-danger" onclick="showDeletePartner({{$partner->pivot->id}}, '{{$partner->name}}')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </div>
</x-adminlte-card>