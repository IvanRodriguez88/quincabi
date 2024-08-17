$(function () {

    const dt = $('#payments-table').DataTable();
	
	window.save = () => {
		const formPayments = $("#paymentsModal-form")
		const action = formPayments.attr('action')
		const method = $("#addEditModal").find('input[name="_method"]').val().toUpperCase()
        $.ajax({
            type: method,
            url: action,
            data: formPayments.serialize(),
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
            success: function (response) {
				const rowIndex = dt.column(0).data().indexOf(response.payment.id.toString());
				$("#closeModal").trigger('click')
				console.log(response);
                
				if (method == "POST") {
					let row = [
						response.payment.id.toString(),
						response.payment.invoice_payment_type.name,
						"$" + formatNumber(response.payment.amount),
						formatDate(response.payment.date),
						getButtons(response.payment.id, response.payment.amount),
					]
					dt.row.add(row).draw(false)
					toastr.success(`The payment has been created successfully`, 'Payment created')
				}else{
					let rowData = dt.row(rowIndex).data();
                    
					rowData[1] = response.payment.invoice_payment_type.name;
					rowData[2] = "$" + formatNumber(response.payment.amount),
					rowData[3] = formatDate(response.payment.date);
                    
					dt.row(rowIndex).data(rowData).draw(false);
					toastr.success(`The payment has been updated successfully`, 'Payment updated')
				}
            },
            error: function (xhr, textStatus, errorThrown) {
                $("#error-messages").hide();
				$("#error-messages").empty().append(getErrorMessages(xhr.responseJSON.errors));
				$("#error-messages").slideDown("fast");
            },
        });
	}

	function getButtons(payment_id, amount) {
		return `<div class="text-center">
					<a class="btn btn-primary" onclick="getAddEditModal('edit', ${payment_id})">
						<i class="fas fa-edit"></i>
					</a>
					<a class="btn btn-danger" onclick="showDelete(${payment_id}, '${amount}')">
						<i class="fas fa-trash"></i>
					</a>
				</div>`
	}

    window.showDelete = (payment_id, amount) => {
		
		const confirm = alertYesNo('Delete payment',`Are you sure to delete the payment of ${amount}?`);
		confirm.then((result) => {
			if (result) {
				$.ajax({
					type: "DELETE",
					url: `${getBaseUrl()}/payments/${payment_id}`,
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function (response) {
						const rowIndex = dt.column(0).data().indexOf(payment_id.toString());
						dt.row(rowIndex).remove().draw(false)
						toastr.success(`The payment has been deleted successfully`, 'Payment deleted')
					},
					error: function (xhr, textStatus, errorThrown) {
						toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
					},
				});
			}
		})
	}

    window.getAddEditModal = (invoice_id, type, id) => {
        
        let url = `${getBaseUrl()}/payments/getaddeditmodal/${invoice_id}`
        if (id !== null){
            url = `${getBaseUrl()}/payments/getaddeditmodal/${invoice_id}/${id}`
        }
        
        $.ajax({
            type: "GET",
            url: url,
            data: {type: type},
            success: function (response) {
                $("#addEditModal").empty().append(response)
                $("#paymentsModal").modal('show')
            },
            error: function (xhr, textStatus, errorThrown) {
                toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
            },
        });
    }
});