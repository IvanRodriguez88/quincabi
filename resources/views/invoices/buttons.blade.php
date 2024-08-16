@if ($invoice->is_paid == 0)
<a class="btn btn-primary" style="width: 40px" href="{{route('invoices.edit', $invoice->id)}}">
    <i class="fas fa-edit"></i>
</a>
@endif

<a class="btn btn-secondary" style="width: 40px" href="{{route('invoices.show', $invoice->id)}}">
    <i class="far fa-eye"></i>
</a>

<a class="btn btn-danger" style="width: 40px" href="{{route('invoices.pdf', $invoice->id)}}" target="_blank">
    <i class="fas fa-file-pdf"></i>
</a>

@if ($invoice->is_paid == 0)
<a class="btn btn-success" style="width: 40px" onclick="payInvoice({{$invoice->id}})">
    <i class="fas fa-money-bill"></i>
</a>
@endif

@if ($invoice->is_paid == 0)
<a class="btn btn-danger" style="width: 40px" onclick="showDelete({{$invoice->id}}, '{{$invoice->name}}')">
    <i class="fas fa-trash"></i>
</a>
@endif