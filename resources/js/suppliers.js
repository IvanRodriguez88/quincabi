$(function () {
	const dt = $('#suppliers-table').DataTable();
	
	window.save = () => {
		const formSuppliers = $("#suppliersModal-form")
		const action = formSuppliers.attr('action')
		const method = $("#addEditModal").find('input[name="_method"]').val().toUpperCase()
        $.ajax({
            type: method,
            url: action,
            data: formSuppliers.serialize(),
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
            success: function (response) {
				const rowIndex = dt.column(0).data().indexOf(response.supplier.id.toString());
				$("#closeModal").trigger('click')
				
				if (method == "POST") {
					let row = [
						response.supplier.id.toString(),
						response.supplier.name,
						response.supplier.address,
						getButtons(response.supplier.id, response.supplier.name),
					]
					dt.row.add(row).draw(false)
					toastr.success(`The supplier ${response.supplier.name} has been created successfully`, 'Supplier created')
				}else{
					let rowData = dt.row(rowIndex).data();
					rowData[1] = response.supplier.name;
					rowData[2] = response.supplier.address;
					dt.row(rowIndex).data(rowData).draw(false);
					toastr.success(`The supplier has been updated successfully`, 'Supplier created')
				}
            },
            error: function (xhr, textStatus, errorThrown) {
                $("#error-messages").hide();
				$("#error-messages").empty().append(getErrorMessages(xhr.responseJSON.errors));
				$("#error-messages").slideDown("fast");
            },
        });
	}

	function getButtons(supplier_id, supplier_name) {
		return `<div class="text-center">
					<a class="btn btn-primary" onclick="getAddEditModal('edit', ${supplier_id})">
						<i class="fas fa-edit"></i>
					</a>
					<a class="btn btn-danger" onclick="showDelete(${supplier_id}, '${supplier_name}')">
						<i class="fas fa-trash"></i>
					</a>
				</div>`
	}

	window.getAddEditModal = (type, id) => {
		let url = `${getBaseUrl()}/suppliers/getaddeditmodal`
		if (id !== null){
			url = `${getBaseUrl()}/suppliers/getaddeditmodal/${id}`
		}
		$.ajax({
			type: "GET",
			url: url,
			data: {type: type},
			success: function (response) {
				$("#addEditModal").empty().append(response)
				$("#suppliersModal").modal('show')
			},
			error: function (xhr, textStatus, errorThrown) {
				toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
			},
		});
	}

	window.showDelete = (supplier_id, supplier_name) => {
		
		const confirm = alertYesNo('Delete supplier',`Are you sure to delete the supplier ${supplier_name}?`);
		confirm.then((result) => {
			if (result) {
				$.ajax({
					type: "DELETE",
					url: `${getBaseUrl()}/suppliers/${supplier_id}`,
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function (response) {
						const rowIndex = dt.column(0).data().indexOf(supplier_id.toString());
						dt.row(rowIndex).remove().draw(false)
						toastr.success(`The supplier has been deleted successfully`, 'Supplier deleted')
					},
					error: function (xhr, textStatus, errorThrown) {
						toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
					},
				});
			}
		})
		
	}
	
})

