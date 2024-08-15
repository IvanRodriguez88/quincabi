$(function () {
	const dt = $('#clients-table').DataTable();
	
	window.save = () => {
		const formClients = $("#clientsModal-form")
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
				const rowIndex = dt.column(0).data().indexOf(response.client.id.toString());
				$("#closeModal").trigger('click')
				
				if (method == "POST") {
					let row = [
						response.client.id.toString(),
						response.client.name,
						response.client.phone,
						response.client.email,
						response.client.address,
						getButtons(response.client.id, response.client.name),
					]
					dt.row.add(row).draw(false)
					toastr.success(`The client ${response.client.name} has been created successfully`, 'Client created')
				}else{
					let rowData = dt.row(rowIndex).data();
					rowData[1] = response.client.name;
					rowData[2] = response.client.phone;
					rowData[3] = response.client.email;
					rowData[4] = response.client.address;
					dt.row(rowIndex).data(rowData).draw(false);
					toastr.success(`The client has been updated successfully`, 'Client created')
				}
            },
            error: function (xhr, textStatus, errorThrown) {
                $("#error-messages").hide();
				$("#error-messages").empty().append(getErrorMessages(xhr.responseJSON.errors));
				$("#error-messages").slideDown("fast");
            },
        });
	}

	function getButtons(client_id, client_name) {
		return `<div class="text-center">
					<a class="btn btn-primary" onclick="getAddEditModal('edit', ${client_id})">
						<i class="fas fa-edit"></i>
					</a>
					<a class="btn btn-danger" onclick="showDelete(${client_id}, '${client_name}')">
						<i class="fas fa-trash"></i>
					</a>
				</div>`
	}

	window.getAddEditModal = (type, id) => {
		let url = `${getBaseUrl()}/clients/getaddeditmodal`
		if (id !== null){
			url = `${getBaseUrl()}/clients/getaddeditmodal/${id}`
		}
		$.ajax({
			type: "GET",
			url: url,
			data: {type: type},
			success: function (response) {
				$("#addEditModal").empty().append(response)
				$("#clientsModal").modal('show')
			},
			error: function (xhr, textStatus, errorThrown) {
				toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
			},
		});
	}

	window.showDelete = (client_id, client_name) => {
		
		const confirm = alertYesNo('Delete client',`Are you sure to delete the client ${client_name}?`);
		confirm.then((result) => {
			if (result) {
				$.ajax({
					type: "DELETE",
					url: `${getBaseUrl()}/clients/${client_id}`,
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function (response) {
						const rowIndex = dt.column(0).data().indexOf(client_id.toString());
						dt.row(rowIndex).remove().draw(false)
						toastr.success(`The client has been deleted successfully`, 'Client deleted')
					},
					error: function (xhr, textStatus, errorThrown) {
						toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
					},
				});
			}
		})
	}
	
})

