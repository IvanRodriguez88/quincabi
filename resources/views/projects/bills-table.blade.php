<x-adminlte-card>
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h3>Bills</h3>
            <a onclick="getAddEditModalBill('add', {{$project->id}})" class="btn btn-default bg-teal px-4">
                <i class="fas fa-plus" style="margin-top:6px"></i> Add 
            </a>
        </div>
    </div>
    <div class="card-body">
        <p class="mb-1">Total bills: <b id="total_bills">${{number_format($project->total_bills, 2, '.', ',')}}</b></p>

		<hr>
        <x-adminlte-datatable id="{{$routeResource}}-table" :heads="$heads" striped hoverable>
            @foreach($project->bills as $bill)
                <tr>
                    <td>{{ $bill->id }}</td>
					<td>{{ $bill->billType->name }}</td>
					<td>{{ $bill->projectPaymentType->name }}</td>
					<td>${{ number_format( $bill->amount ?? 0, 2, ".", ",") }}</td>
					<td>{{ date("m/d/Y", strtotime($bill->date)) }}</td>
					<td>{{ $bill->description }}</td>
					<td class="text-center">
						<a class="btn btn-primary" onclick="getAddEditModalBill('edit', {{$bill->project->id}}, {{$bill->id}})">
							<i class="fas fa-edit"></i>
						</a>
						<a class="btn btn-danger" onclick="showDeleteBill({{$bill->id}}, '{{$bill->amount}}')">
							<i class="fas fa-trash"></i>
						</a>
					</td>
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </div>
</x-adminlte-card>