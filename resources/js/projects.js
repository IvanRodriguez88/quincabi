$(function () {
    const dtPW = $('#project-workers-table').DataTable({
        destroy: true, 
        columnDefs: [
            {
                targets: 0,
                visible: false,
                searchable: false
            }
        ]
    });

    const dtPayments = $("#project_payments-table").DataTable({
        destroy: true, // Permite reinicializar
        columnDefs: [
            {
                targets: 0,
                visible: false,
                searchable: false 
            }
        ]
    })

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

    window.getAddEditModal = (type, project_id, id) => {
		let url = `${getBaseUrl()}/project_workers/getaddeditmodal/${project_id}`
		if (id !== null){
			url = `${getBaseUrl()}/project_workers/getaddeditmodal/${project_id}/${id}`
		}
		$.ajax({
			type: "GET",
			url: url,
			data: {type: type},
			success: function (response) {
				$("#addEditModal").empty().append(response)
				$("#project_workersModal").modal('show')
			},
			error: function (xhr, textStatus, errorThrown) {
				toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
			},
		});
	}

    window.getAddEditModalPayment = (type, project_id, id) => {
		let url = `${getBaseUrl()}/project_payments/getaddeditmodal/${project_id}`
		if (id !== null){
			url = `${getBaseUrl()}/project_payments/getaddeditmodal/${project_id}/${id}`
		}
		$.ajax({
			type: "GET",
			url: url,
			data: {type: type},
			success: function (response) {
				$("#addEditModal").empty().append(response)
				$("#project_paymentsModal").modal('show')
			},
			error: function (xhr, textStatus, errorThrown) {
				toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
			},
		});
	}

    $("#worker_id").on("change", function(){
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

    window.showDeleteWorker = (project_worker_id, worker_name) => {
		const confirm = alertYesNo('Delete worker',`Are you sure to delete the worker ${worker_name}?`);
		confirm.then((result) => {
			if (result) {
				$.ajax({
					type: "DELETE",
					url: `${getBaseUrl()}/project_workers/${project_worker_id}`,
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function (response) {
						const rowIndex = dtPW.column(0).data().indexOf(project_worker_id.toString());
                        
						dtPW.row(rowIndex).remove().draw(false)
						toastr.success(`The worker has been deleted successfully`, 'Client deleted')
					},
					error: function (xhr, textStatus, errorThrown) {
						toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
					},
				});
			}
		})
	}

    window.save = () => {
		const formProjectWorkers = $("#project_workersModal-form")
		const action = formProjectWorkers.attr('action')
		const method = $("#addEditModal").find('input[name="_method"]').val().toUpperCase()
        console.log(action);
        
        $.ajax({
            type: method,
            url: action,
            data: formProjectWorkers.serialize(),
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
            success: function (response) {
                
                const rowIndex = dtPW.column(0).data().indexOf(response.project_worker.id.toString());
                console.log(rowIndex);
				$("#closeModal").trigger('click')

                
				
				if (method == "POST") {
					let row = [
                        response.project_worker.id.toString(),
						response.project_worker.worker.name,
                        `$ ${formatNumber(response.project_worker.hourly_pay)}`,
						`$ ${formatNumber(response.project_worker.worked_hours)}`,
                        `$ ${formatNumber(response.project_worker.hourly_pay * response.project_worker.worked_hours)}`,
						getButtons(response.project_worker.id, response.project_worker.worker.name),
					]
                    
					dtPW.row.add(row).draw(false)
					toastr.success(`Worker ${response.project_worker.name} has been added successfully`, 'Worker added')
				}else{
					let rowData = dtPW.row(rowIndex).data();
					rowData[1] = response.project_worker.worker.name;
					rowData[2] = `$ ${formatNumber(response.project_worker.hourly_pay)}`;
					rowData[3] = `$ ${formatNumber(response.project_worker.worked_hours)}`;
                    rowData[4] = `$ ${formatNumber(response.project_worker.hourly_pay * response.project_worker.worked_hours)}`;
					dtPW.row(rowIndex).data(rowData).draw(false);
					toastr.success(`Worker has been updated successfully`, 'Worker updated')
				}
            },
            error: function (xhr, textStatus, errorThrown) {
                $("#error-messages").hide();
				$("#error-messages").empty().append(getErrorMessages(xhr.responseJSON.errors));
				$("#error-messages").slideDown("fast");
            },
        });
	}

	function getButtons(project_worker_id, worker_name) {
		return `<div class="text-center">
            <a class="btn btn-primary" onclick="getAddEditModal('edit', ${$("#project_id").val()} ,${project_worker_id})">
                <i class="fas fa-edit"></i>
            </a>
            <a class="btn btn-danger" onclick="showDeleteWorker(${project_worker_id}, '${worker_name}')">
                <i class="fas fa-trash"></i>
            </a>
        </div>`
	}

    function getButtonsPayments(project_payment_id, amount) {
		return `<div class="text-center">
            <a class="btn btn-primary" onclick="getAddEditModalPayment('edit', ${$("#project_id").val()} ,${project_payment_id})">
                <i class="fas fa-edit"></i>
            </a>
            <a class="btn btn-danger" onclick="showDeletePayment(${project_payment_id}, '${amount}')">
                <i class="fas fa-trash"></i>
            </a>
        </div>`
	}



    //Payments
    window.savePayment = () => {
		const formProjectWorkers = $("#project_paymentsModal-form")
		const action = formProjectWorkers.attr('action')
		const method = $("#addEditModal").find('input[name="_method"]').val().toUpperCase()
        
        $.ajax({
            type: method,
            url: action,
            data: formProjectWorkers.serialize(),
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
            success: function (response) {
                
                const rowIndex = dtPayments.column(0).data().indexOf(response.payment.id.toString());
				$("#closeModal").trigger('click')
                $("#total_payment").text(`$${formatNumber(response.project.total_payments)}`)
                
				if (method == "POST") {
					let row = [
						response.payment.id.toString(),
						response.payment.project_payment_type.name,
						"$" + formatNumber(response.payment.amount),
						formatDate(response.payment.date),
						getButtonsPayments(response.payment.id, response.payment.amount),
					]
					dtPayments.row.add(row).draw(false)
					toastr.success(`The payment has been created successfully`, 'Payment created')
				}else{
					let rowData = dtPayments.row(rowIndex).data();
                    
					rowData[1] = response.payment.project_payment_type.name;
					rowData[2] = "$" + formatNumber(response.payment.amount),
					rowData[3] = formatDate(response.payment.date);
                    
					dtPayments.row(rowIndex).data(rowData).draw(false);
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

    window.showDeletePayment = (project_payment_id, payment_amount) => {
		const confirm = alertYesNo('Delete payment',`Are you sure to delete the payment for $${formatNumber(payment_amount)}?`);
		confirm.then((result) => {
			if (result) {
				$.ajax({
					type: "DELETE",
					url: `${getBaseUrl()}/project_payments/${project_payment_id}`,
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function (response) {
						const rowIndex = dtPayments.column(0).data().indexOf(project_payment_id.toString());
                        $("#total_payment").text(`$${formatNumber(response.project.total_payments)}`)
						dtPayments.row(rowIndex).remove().draw(false)
						toastr.success(`The payment has been deleted successfully`, 'Client deleted')
					},
					error: function (xhr, textStatus, errorThrown) {
						toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
					},
				});
			}
		})
	}
    
    $(document).on('change', '#upload-image', function (e) {
        const file = e.target.files[0];
        const formData = new FormData();
        formData.append('image', file);
    
        $.ajax({
            url: `${getBaseUrl()}/projects/uploadImage/${$("#project_id").val()}`,
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: false,  // Esto es importante para enviar archivos
            processData: false,  // Necesario para que jQuery no intente procesar los datos
            success: function(data) {
                // Mostrar vista previa con botón de eliminación
                const img = $('<img>', {
                    src: data.url, // URL de la imagen desde el servidor
                    css: {
                        width: '100%',
                        height: '100%',
                        objectFit: 'cover', // Ajusta la imagen dentro del cuadro
                    }
                });

                const previewContainer = $('<div>', {
                    class: 'image-preview-container position-relative d-inline-block project-picture',
                });
                previewContainer.attr('data-filename', data.name);
                previewContainer.attr('data-picture_id', data.picture_id);
                
                const deleteButton = $('<a>', {
                    class: 'delete-image-btn btn btn-danger btn-sm position-absolute',
                    text: 'X',
                    click: function () {
                        deleteProjectPicture(data.name, data.picture_id)
                    }
                });

                // Ensamblar y agregar al DOM
                previewContainer.append(img).append(deleteButton);
                $('#image-preview').append(previewContainer);
            },
            error: function(error) {
                console.error('Error al subir la imagen:', error);
            }
        });
    });

    window.deleteProjectPicture = (filename, picture_id) => {
        const confirm = alertYesNo('Delete image',`Are you sure to delete it?`);
        confirm.then((result) => {
            if (result) {
                $.ajax({
                    url: `${getBaseUrl()}/projects/deleteImage/${picture_id}`,
                    method: 'DELETE',
                    data: { name: filename },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function () {
                        $('.image-preview-container').filter(`[data-picture_id="${picture_id}"]`).remove();
                    },
                    error: function () {
                        alert('Error al eliminar la imagen.');
                    }
                });
            }
        })
    }


    


})