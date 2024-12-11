<input type="hidden" name="project_id" value="{{$data['project']->id}}">
<x-adminlte-select id="invoice_id" name="invoice_id" label="Invoice" required fgroup-class="col-md-12">
    <option disabled selected>Select an invocie without project...</option>
    @foreach ($data["invoices"] as $invoice)
        <option value="{{$invoice->id}}">#{{$invoice->id}} - {{$invoice->name}}</option>
    @endforeach
</x-adminlte-select>