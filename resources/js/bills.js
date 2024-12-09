$(function () {
	const dt = $('#bills-table').DataTable();
	
	window.save = () => {
		const formClients = $("#billsModal-form")
		const action = formClients.attr('action')
		const method = $("#addEditModal").find('input[name="_method"]').val().toUpperCase()
        $.ajax({
            type: method,
            url: action,
            data: formClients.serialize(),
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
            success: function (response) {
				const rowIndex = dt.column(0).data().indexOf(response.bill.id.toString());
				$("#closeModal").trigger('click')
				if (method == "POST") {
					let row = [
						response.bill.id.toString(),
						response.bill.project == null ? "Without project" : response.bill.project.name,
						response.bill.bill_type.name,
						response.bill.project_payment_type.name,
						`$${formatNumber(response.bill.amount)}`,
						formatDate(response.bill.date),
						response.bill.description,
						getButtons(response.bill.id, response.bill.amount),
					]
					dt.row.add(row).draw(false)
					toastr.success(`The bill has been created successfully`, 'Bill created')
				}else{
					let rowData = dt.row(rowIndex).data();
					rowData[2] = response.bill.bill_type.name,
					rowData[3] = response.bill.project_payment_type.name,
					rowData[4] = `$${formatNumber(response.bill.amount)}`,
					rowData[5] = formatDate(response.bill.date),
					rowData[6] = response.bill.description,
					dt.row(rowIndex).data(rowData).draw(false);
					toastr.success(`The bill has been updated successfully`, 'Bill created')
				}
            },
            error: function (xhr, textStatus, errorThrown) {
                $("#error-messages").hide();
				$("#error-messages").empty().append(getErrorMessages(xhr.responseJSON.errors));
				$("#error-messages").slideDown("fast");
            },
        });
	}

	function getButtons(bill_id, amount) {
		return `<div class="text-center">
					<a class="btn btn-primary" onclick="getAddEditModal('edit', ${bill_id})">
						<i class="fas fa-edit"></i>
					</a>
					<a class="btn btn-danger" onclick="showDelete(${bill_id}, '${amount}')">
						<i class="fas fa-trash"></i>
					</a>
				</div>`
	}

	window.getAddEditModal = (type, id) => {
		let url = `${getBaseUrl()}/bills/getaddeditmodal`
		if (id !== null){
			url = `${getBaseUrl()}/bills/getaddeditmodal/${id}`
		}
		$.ajax({
			type: "GET",
			url: url,
			data: {type: type},
			success: function (response) {
				$("#addEditModal").empty().append(response)
				$("#billsModal").modal('show')
			},
			error: function (xhr, textStatus, errorThrown) {
				toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
			},
		});
	}

	window.showDelete = (bill_id, amount) => {
		
		const confirm = alertYesNo('Delete bill',`Are you sure to delete the bill for an amount of $${formatNumber(amount)}?`);
		confirm.then((result) => {
			if (result) {
				$.ajax({
					type: "DELETE",
					url: `${getBaseUrl()}/bills/${bill_id}`,
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function (response) {
						const rowIndex = dt.column(0).data().indexOf(bill_id.toString());
						dt.row(rowIndex).remove().draw(false)
						toastr.success(`The bill has been deleted successfully`, 'Bill deleted')
					},
					error: function (xhr, textStatus, errorThrown) {
						toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
					},
				});
			}
		})
	}
	
})

