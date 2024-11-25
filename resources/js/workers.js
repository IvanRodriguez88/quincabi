$(function () {
	const dt = $('#workers-table').DataTable();
	
	window.save = () => {
		const formClients = $("#workersModal-form")
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
				const rowIndex = dt.column(0).data().indexOf(response.worker.id.toString());
				$("#closeModal").trigger('click')
				
				if (method == "POST") {
					let row = [
						response.worker.id.toString(),
						response.worker.name,
						`$ ${formatNumber(response.worker.hourly_pay)}`,
						response.worker.phone,
						response.worker.email,
						getButtons(response.worker.id, response.worker.name),
					]
					dt.row.add(row).draw(false)
					toastr.success(`The worker ${response.worker.name} has been created successfully`, 'Client created')
				}else{
					let rowData = dt.row(rowIndex).data();
					rowData[1] = response.worker.name;
					rowData[2] = `$ ${formatNumber(response.worker.hourly_pay)}`
					rowData[3] = response.worker.phone;
					rowData[4] = response.worker.email;
					dt.row(rowIndex).data(rowData).draw(false);
					toastr.success(`The worker has been updated successfully`, 'Client created')
				}
            },
            error: function (xhr, textStatus, errorThrown) {
                $("#error-messages").hide();
				$("#error-messages").empty().append(getErrorMessages(xhr.responseJSON.errors));
				$("#error-messages").slideDown("fast");
            },
        });
	}

	function getButtons(worker_id, worker_name) {
		return `<div class="text-center">
					<a class="btn btn-primary" onclick="getAddEditModal('edit', ${worker_id})">
						<i class="fas fa-edit"></i>
					</a>
					<a class="btn btn-danger" onclick="showDelete(${worker_id}, '${worker_name}')">
						<i class="fas fa-trash"></i>
					</a>
				</div>`
	}

	window.getAddEditModal = (type, id) => {
		let url = `${getBaseUrl()}/workers/getaddeditmodal`
		if (id !== null){
			url = `${getBaseUrl()}/workers/getaddeditmodal/${id}`
		}
		$.ajax({
			type: "GET",
			url: url,
			data: {type: type},
			success: function (response) {
				$("#addEditModal").empty().append(response)
				$("#workersModal").modal('show')
			},
			error: function (xhr, textStatus, errorThrown) {
				toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
			},
		});
	}

	window.showDelete = (worker_id, worker_name) => {
		
		const confirm = alertYesNo('Delete worker',`Are you sure to delete the worker ${worker_name}?`);
		confirm.then((result) => {
			if (result) {
				$.ajax({
					type: "DELETE",
					url: `${getBaseUrl()}/workers/${worker_id}`,
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function (response) {
						const rowIndex = dt.column(0).data().indexOf(worker_id.toString());
						dt.row(rowIndex).remove().draw(false)
						toastr.success(`The worker has been deleted successfully`, 'Client deleted')
					},
					error: function (xhr, textStatus, errorThrown) {
						toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
					},
				});
			}
		})
	}
	
})

