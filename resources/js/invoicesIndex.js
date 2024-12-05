$(function () {

    const dt = $('#invoices-table').DataTable();

    function getButtons(invoice_id) {
        
        return new Promise((resolve, reject) => {
            $.ajax({
                url:  `${getBaseUrl()}/invoices/getbuttons/${invoice_id}`,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    resolve(response);
                },
                error: function(xhr, textStatus, errorThrown) {
                    reject(xhr.responseJSON.errors); 
                }
            });
        });
    }
    
    window.copyInvoice = (invoice_id) => {
		const confirm = alertYesNo('Copy invoice',`Are you sure to copy the invoice #${invoice_id}`);
        confirm.then((result) => {
            if (result) {
                $.ajax({
                    url: `${getBaseUrl()}/invoices/copyInvoice/${invoice_id}`,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        console.log(response);
                        
                        let row = [
                            response.invoice.id.toString(),
                            response.invoice.project == null ? "Without project" : `<a href="${getBaseUrl()}/projects/${response.invoice.project.id}/edit">${response.invoice.project.name}</a>`,
                            response.invoice.name,
                            response.invoice.client.name,
                            "$" + formatNumber(response.invoice.cost),
                            "$" + formatNumber(response.invoice.total),
                            formatDate(response.invoice.date_issued),
                            formatDate(response.invoice.date_due),
                            getUsing(response.invoice.in_use),
                            response.buttons,
                        ]
                        dt.row.add(row).draw(false)
                        $("#cost_proyected").text("$" + formatNumber(response.invoice.project.total_invoice_costs))
                        $("#total_real").val(response.invoice.project.total_invoice_prices)
                        toastr.success(`The invoice has been copied successfully`, 'Invoice copied')
                    },
                   error: function (xhr, textStatus, errorThrown) {
						toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
					},
                });
            }
        })
	}

    function getUsing(in_use){
        if (in_use) {
            return '<span class="badge badge-success">Yes</span>'
        }else{
            return '<span class="badge badge-danger">No</span>'
        }
    }

    window.showDelete = (invoice_id) => {
		
		const confirm = alertYesNo('Delete invoice',`Are you sure to delete the invoice #${invoice_id}?`);
		confirm.then((result) => {
			if (result) {
				$.ajax({
					type: "DELETE",
					url: `${getBaseUrl()}/invoices/${invoice_id}`,
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function (response) {
						const rowIndex = dt.column(0).data().indexOf(invoice_id.toString());
						dt.row(rowIndex).remove().draw(false)
						toastr.success(`The invoice has been deleted successfully`, 'Invoice deleted')
					},
					error: function (xhr, textStatus, errorThrown) {
						toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
					},
				});
			}
		})
	}
    

});