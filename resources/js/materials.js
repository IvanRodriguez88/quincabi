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

});