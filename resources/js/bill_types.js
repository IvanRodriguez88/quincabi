$(function () {
	const dt = $('#bill_types-table').DataTable();
	
	window.save = () => {
		const formBillTypes = $("#bill_typesModal-form")
		const action = formBillTypes.attr('action')
		const method = $("#addEditModal").find('input[name="_method"]').val().toUpperCase()
        $.ajax({
            type: method,
            url: action,
            data: formBillTypes.serialize(),
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
            success: function (response) {
				const rowIndex = dt.column(0).data().indexOf(response.bill_type.id.toString());
				$("#closeModal").trigger('click')
				
				if (method == "POST") {
					let row = [
						response.bill_type.id.toString(),
						response.bill_type.name,
						getButtons(response.bill_type.id, response.bill_type.name),
					]
					dt.row.add(row).draw(false)
					toastr.success(`The bill type ${response.bill_type.name} has been created successfully`, 'Bill Type created')
				}else{
					let rowData = dt.row(rowIndex).data();
					rowData[1] = response.bill_type.name;
					dt.row(rowIndex).data(rowData).draw(false);
					toastr.success(`The bill type has been updated successfully`, 'Bill Type created')
				}
            },
            error: function (xhr, textStatus, errorThrown) {
                $("#error-messages").hide();
				$("#error-messages").empty().append(getErrorMessages(xhr.responseJSON.errors));
				$("#error-messages").slideDown("fast");
            },
        });
	}

	function getButtons(bill_type_id, bill_type_name) {
		return `<div class="text-center">
					<a class="btn btn-primary" onclick="getAddEditModal('edit', ${bill_type_id})">
						<i class="fas fa-edit"></i>
					</a>
					<a class="btn btn-danger" onclick="showDelete(${bill_type_id}, '${bill_type_name}')">
						<i class="fas fa-trash"></i>
					</a>
				</div>`
	}

	window.getAddEditModal = (type, id) => {
		let url = `${getBaseUrl()}/bill_types/getaddeditmodal`
		if (id !== null){
			url = `${getBaseUrl()}/bill_types/getaddeditmodal/${id}`
		}
		$.ajax({
			type: "GET",
			url: url,
			data: {type: type},
			success: function (response) {
				$("#addEditModal").empty().append(response)
				$("#bill_typesModal").modal('show')
			},
			error: function (xhr, textStatus, errorThrown) {
				toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
			},
		});
	}

	window.showDelete = (bill_type_id, bill_type_name) => {
		
		const confirm = alertYesNo('Delete bill type',`Are you sure to delete the bill type ${bill_type_name}?`);
		confirm.then((result) => {
			if (result) {
				$.ajax({
					type: "DELETE",
					url: `${getBaseUrl()}/bill_types/${bill_type_id}`,
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function (response) {
						const rowIndex = dt.column(0).data().indexOf(bill_type_id.toString());
						dt.row(rowIndex).remove().draw(false)
						toastr.success(`The bill type has been deleted successfully`, 'Bill Type deleted')
					},
					error: function (xhr, textStatus, errorThrown) {
						toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
					},
				});
			}
		})
	}
	
})

