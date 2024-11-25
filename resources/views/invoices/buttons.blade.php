<a class="btn btn-primary" style="width: 40px" href="{{route('invoices.edit', $invoice->id)}}">
    <i class="fas fa-edit"></i>
</a>
<a class="btn btn-secondary" style="width: 40px" href="{{route('invoices.show', $invoice->id)}}">
    <i class="far fa-eye"></i>
</a>

<a class="btn btn-danger" style="width: 40px" href="{{route('invoices.pdf', $invoice->id)}}" target="_blank">
    <i class="fas fa-file-pdf"></i>
</a>
