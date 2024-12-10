$(function () {
	const dt = $('#partners-table').DataTable();
	
	window.save = () => {
		const formPartners = $("#partnersModal-form")
		const action = formPartners.attr('action')
		const method = $("#addEditModal").find('input[name="_method"]').val().toUpperCase()
        $.ajax({
            type: method,
            url: action,
            data: formPartners.serialize(),
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
            success: function (response) {
				console.log(response);
				
				const rowIndex = dt.column(0).data().indexOf(response.partner.id.toString());
				$("#closeModal").trigger('click')
				
				if (method == "POST") {
					let row = [
						response.partner.id.toString(),
						response.partner.name,
						`${response.partner.percentage}%`,
						getButtons(response.partner.id, response.partner.name),
					]
					dt.row.add(row).draw(false)
					toastr.success(`The partner ${response.partner.name} has been created successfully`, 'Bill Type created')
				}else{
					let rowData = dt.row(rowIndex).data();
					rowData[1] = response.partner.name;
					rowData[2] = `${response.partner.percentage}%`;
					dt.row(rowIndex).data(rowData).draw(false);
					toastr.success(`The partner has been updated successfully`, 'Bill Type created')
				}
            },
            error: function (xhr, textStatus, errorThrown) {
                $("#error-messages").hide();
				$("#error-messages").empty().append(getErrorMessages(xhr.responseJSON.errors));
				$("#error-messages").slideDown("fast");
            },
        });
	}

	function getButtons(partner_id, partner_name) {
		return `<div class="text-center">
					<a class="btn btn-primary" onclick="getAddEditModal('edit', ${partner_id})">
						<i class="fas fa-edit"></i>
					</a>
					<a class="btn btn-danger" onclick="showDelete(${partner_id}, '${partner_name}')">
						<i class="fas fa-trash"></i>
					</a>
				</div>`
	}

	window.getAddEditModal = (type, id) => {
		let url = `${getBaseUrl()}/partners/getaddeditmodal`
		if (id !== null){
			url = `${getBaseUrl()}/partners/getaddeditmodal/${id}`
		}
		$.ajax({
			type: "GET",
			url: url,
			data: {type: type},
			success: function (response) {
				$("#addEditModal").empty().append(response)
				$("#partnersModal").modal('show')
			},
			error: function (xhr, textStatus, errorThrown) {
				toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
			},
		});
	}

	window.showDelete = (partner_id, partner_name) => {
		
		const confirm = alertYesNo('Delete partner',`Are you sure to delete the partner ${partner_name}?`);
		confirm.then((result) => {
			if (result) {
				$.ajax({
					type: "DELETE",
					url: `${getBaseUrl()}/partners/${partner_id}`,
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function (response) {
						const rowIndex = dt.column(0).data().indexOf(partner_id.toString());
						dt.row(rowIndex).remove().draw(false)
						toastr.success(`The partner has been deleted successfully`, 'Partner deleted')
					},
					error: function (xhr, textStatus, errorThrown) {
						toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
					},
				});
			}
		})
	}
	
})

