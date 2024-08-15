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
    
    window.payInvoice = (invoice_id) => {
        const confirm = alertYesNo('Pay invoice', `Are you sure to pay the invoice #${invoice_id}?`);
        confirm.then((result) => {
            if (result) {
                // Obtener los botones antes de proceder con el pago
                $.ajax({
                    url: `${getBaseUrl()}/invoices/payinvoice/${invoice_id}`,
                    type: "PUT",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        getButtons(invoice_id).then(buttonsData => {
                            const rowIndex = dt.column(0).data().indexOf(response.invoice.id.toString());
                            let rowData = dt.row(rowIndex).data();
                            rowData[7] = "<span class='badge badge-success p-2 px-3'>Yes</span>";
                            rowData[8] = buttonsData;
                            dt.row(rowIndex).data(rowData).draw(false);
                        }).catch(error => {
                            $("#error-messages").hide();
                            $("#error-messages").empty().append(`<p>${error}</p>`);
                            $("#error-messages").slideDown("fast");
                        });
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        $("#error-messages").hide();
                        $("#error-messages").empty().append(getErrorMessages(xhr.responseJSON.errors));
                        $("#error-messages").slideDown("fast");
                    }
                });
            }
        });
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