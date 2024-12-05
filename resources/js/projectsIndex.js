$(function () {
    const dt = $('#projects-table').DataTable();

    $("#client_id").on("change", function(){
        $.ajax({
            url: `${getBaseUrl()}/projects/getclientinfo/${$(this).val()}`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                $("#client_info").empty().append(response)
            },error: function(xhr, textStatus, errorThrown) {
                errorMessage(xhr.status, errorThrown)
            }
        });
    })

    window.getAddEditModal = (type) => {
		let url = `${getBaseUrl()}/projects/getaddeditmodal`
		$.ajax({
			type: "GET",
			url: url,
			data: {type: type},
			success: function (response) {
				$("#addEditModal").empty().append(response)
				$("#projectsModal").modal('show')
			},
			error: function (xhr, textStatus, errorThrown) {
				toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
			},
		});
	}

    window.save = () => {
		const formProjects = $("#projectsModal-form")
		const action = formProjects.attr('action')
		const method = $("#addEditModal").find('input[name="_method"]').val().toUpperCase()
		
        $.ajax({
            type: method,
            url: action,
            data: formProjects.serialize(),
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
            success: function (response) {
				console.log(response);
				$("#closeModal").trigger('click')
				
				if (method == "POST") {
					toastr.success(`The project ${response.project.name} has been created successfully`, 'Project created')
                    setTimeout(() => {
                        window.location = `${getBaseUrl()}/projects/${response.project.id}/edit`
                    }, 1000);
				}
            },
            error: function (xhr, textStatus, errorThrown) {
                $("#error-messages").hide();
				$("#error-messages").empty().append(getErrorMessages(xhr.responseJSON.errors));
				$("#error-messages").slideDown("fast");
            },
        });
	}

    window.showDelete = (project_id, project_name) => {
		
		const confirm = alertYesNo('Delete project',`Are you sure to delete the project '${project_name}' PERMANENTLY?`);
		confirm.then((result) => {
			if (result) {
				$.ajax({
					type: "DELETE",
					url: `${getBaseUrl()}/projects/${project_id}`,
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function (response) {
						const rowIndex = dt.column(0).data().indexOf(project_id.toString());
						dt.row(rowIndex).remove().draw(false)
						toastr.success(`The project has been deleted successfully`, 'Project deleted')
					},
					error: function (xhr, textStatus, errorThrown) {
						toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
					},
				});
			}
		})
	}

})