<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePayment extends Model
{
    use HasFactory;

    protected $table = 'invoice_payments';
	protected $fillable = ['invoice_id', 'invoice_payment_type_id', 'date', 'amount', 'is_active', 'created_by', 'updated_by'];

    public function invoice()
    {
        return $this->belongsTo("App\Models\Invoice", "invoice_id", "id");
    }

    public function invoicePaymentType()
    {
        return $this->belongsTo("App\Models\InvoicePaymentType", "invoice_payment_type_id", "id");
    }

}
