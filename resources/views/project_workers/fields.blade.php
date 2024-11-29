<div class="row">
    <input type="hidden" name="project_id" value="{{$data['project']->id}}">

    @if (isset($data["project_worker"]))
     <x-adminlte-select id="worker_id" name="worker_id" label="Worker" required fgroup-class="col-md-4">
            <option disabled>Select a worker...</option>
            @foreach ($data["workers"] as $worker)
                <option value="{{$worker->id}}" {{$worker->id == $data["project_worker"]->id ? 'selected' : ''}}>{{$worker->name}}</option>
            @endforeach
        </x-adminlte-select>
    @else
        <x-adminlte-select id="worker_id" name="worker_id" label="Worker" required fgroup-class="col-md-4">
            <option disabled selected>Select a worker...</option>
            @foreach ($data["workers"] as $worker)
                <option value="{{$worker->id}}">{{$worker->name}}</option>
            @endforeach
        </x-adminlte-select>
    @endif
  

    <x-adminlte-input 
        value="{{($data['project_worker']->hourly_pay) ?? ''}}" 
        name="hourly_pay" 
        label="Hourly Pay" 
        placeholder="Hourly pay"
        fgroup-class="col-md-4" 
        disable-feedback
        type="number"
    />
    <x-adminlte-input 
        value="{{($data['project_worker']->worked_hours) ?? ''}}" 
        name="worked_hours" 
        label="Worked Hours" 
        placeholder="Worked hours"
        fgroup-class="col-md-4" 
        disable-feedback
        type="number"
    />
</div>

<script>
	$("#worker_id").on("change", function(){
        $.ajax({
            url: `${getBaseUrl()}/workers/getworker/${$(this).val()}`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                $("#hourly_pay").val(response.hourly_pay)
            },error: function(xhr, textStatus, errorThrown) {
                errorMessage(xhr.status, errorThrown)
            }
        });
    })
</script>