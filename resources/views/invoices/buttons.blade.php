@if ($invoice->is_paid == 0)
<a class="btn btn-primary" href="{{route('invoices.edit', $invoice->id)}}">
    <i class="fas fa-edit"></i>
</a>
@endif

<a class="btn btn-secondary" href="{{route('invoices.show', $invoice->id)}}">
    <i class="far fa-eye"></i>
</a>

@if ($invoice->is_paid == 0)
<a class="btn btn-success" onclick="payInvoice({{$invoice->id}})">
    <i class="fas fa-money-bill"></i>
</a>
@endif

@if ($invoice->is_paid == 0)
<a class="btn btn-danger" onclick="showDelete({{$invoice->id}}, '{{$invoice->name}}')">
    <i class="fas fa-trash"></i>
</a>
@endif