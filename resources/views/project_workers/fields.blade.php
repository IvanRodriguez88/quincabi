<div class="row">
<x-adminlte-select id="worker_id" name="worker_id" label="Worker" required fgroup-class="col-md-4">
    <option disabled selected>Select a worker...</option>
    @foreach ($data["workers"] as $worker)
        <option value="{{$worker->id}}">{{$worker->name}}</option>
    @endforeach
</x-adminlte-select>

<x-adminlte-input 
    value="{{($data->hourly_pay) ?? ''}}" 
    name="hourly_pay" 
    label="Hourly Pay" 
    placeholder="Hourly pay"
    fgroup-class="col-md-4" 
    disable-feedback
    type="number"
/>
<x-adminlte-input 
    value="{{($data->worked_hours) ?? ''}}" 
    name="worked_hours" 
    label="Worked Hours" 
    placeholder="Worked hours"
    fgroup-class="col-md-4" 
    disable-feedback
    type="number"
/>
</div>