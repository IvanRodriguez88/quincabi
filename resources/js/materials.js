$(function () {
	const dt = $('#materials-table').DataTable();

    window.getAddEditModal = (type, id) => {
		let url = `${getBaseUrl()}/materials/getaddeditmodal`
		if (id !== null){
			url = `${getBaseUrl()}/materials/getaddeditmodal/${id}`
		}
		$.ajax({
			type: "GET",
			url: url,
			data: {type: type},
			success: function (response) {
				$("#addEditModal").empty().append(response)
				$("#materialsModal").modal('show')
			},
			error: function (xhr, textStatus, errorThrown) {
				toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
			},
		});
	}

	

	window.save = () => {
		const formMaterials = $("#materialsModal-form")
		const action = formMaterials.attr('action')
		const method = $("#addEditModal").find('input[name="_method"]').val().toUpperCase()
		
        $.ajax({
            type: method,
            url: action,
            data: formMaterials.serialize(),
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
            success: function (response) {
				console.log(response);
				const rowIndex = dt.column(0).data().indexOf(response.material.id.toString());
				$("#closeModal").trigger('click')
				
				if (method == "POST") {
					let row = [
						response.material.id.toString(),
						response.material.name,
						getButtons(response.material.id, response.material.name),
					]
					dt.row.add(row).draw(false)
					toastr.success(`The material ${response.material.name} has been created successfully`, 'Category created')
				}else{
					let rowData = dt.row(rowIndex).data();
					rowData[1] = response.material.name;
					dt.row(rowIndex).data(rowData).draw(false);
					toastr.success(`The material has been updated successfully`, 'Category created')
				}
            },
            error: function (xhr, textStatus, errorThrown) {
                $("#error-messages").hide();
				$("#error-messages").empty().append(getErrorMessages(xhr.responseJSON.errors));
				$("#error-messages").slideDown("fast");
            },
        });
	}

	window.showDelete = (material_id, material_name) => {
		
		const confirm = alertYesNo('Delete material',`Are you sure to delete the material ${material_name}?`);
		confirm.then((result) => {
			if (result) {
				$.ajax({
					type: "DELETE",
					url: `${getBaseUrl()}/materials/${material_id}`,
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function (response) {
						const rowIndex = dt.column(0).data().indexOf(material_id.toString());
						dt.row(rowIndex).remove().draw(false)
						toastr.success(`The material has been deleted successfully`, 'Material deleted')
					},
					error: function (xhr, textStatus, errorThrown) {
						toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
					},
				});
			}
		})
	}

	function getButtons(material_id, material_name) {
		return `<div class="text-center">
					<a class="btn btn-primary" onclick="getAddEditModal('edit', ${material_id})">
						<i class="fas fa-edit"></i>
					</a>
					<a class="btn btn-danger" onclick="showDelete(${material_id}, '${material_name}')">
						<i class="fas fa-trash"></i>
					</a>
				</div>`
	}
});