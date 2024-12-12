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

	const dtPP = $('#project-partners-table').DataTable({
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

	const dtBills = $("#bills-table").DataTable({
        destroy: true, // Permite reinicializar
        columnDefs: [
            {
                targets: 0,
                visible: false,
                searchable: false 
            }
        ]
    })

    const dtInvoices = $("#project-invoices-table").DataTable()

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

	window.getAddEditModalPartner = (type, project_id, id) => {
		let url = `${getBaseUrl()}/project_partners/getaddeditmodal/${project_id}`
		if (id !== null){
			url = `${getBaseUrl()}/project_partners/getaddeditmodal/${project_id}/${id}`
		}
		$.ajax({
			type: "GET",
			url: url,
			data: {type: type},
			success: function (response) {
				$("#addEditModal").empty().append(response)
				$("#project_partnersModal").modal('show')
			},
			error: function (xhr, textStatus, errorThrown) {
				toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
			},
		});
	}

	window.getAddEditModalBill = (type, project_id, id) => {
		let url = `${getBaseUrl()}/bills/getaddeditmodalproject/${project_id}`
		if (id !== null){
			url = `${getBaseUrl()}/bills/getaddeditmodalproject/${project_id}/${id}`
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

	window.addExistingInvoiceModal = (project_id) => {
		let url = `${getBaseUrl()}/projects/addExistingInvoiceModal/${project_id}`
		$.ajax({
			type: "GET",
			url: url,
			data: {type: 'add'},
			success: function (response) {
				$("#addEditModal").empty().append(response)
				$("#invoiceModal").modal('show')
			},
			error: function (xhr, textStatus, errorThrown) {
				toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
			},
		});
	}

	window.addExistingInvoice = () => {
		let url = `${getBaseUrl()}/projects/addExistingInvoice`
		const formInvoices = $("#invoiceModal-form")

		$.ajax({
			type: "POST",
			url: url,
			data: formInvoices.serialize(),
			headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
			success: function (response) {
				window.location.reload()
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
						$("#total_worked_hours").text(response.project.total_worked_hours)
						$("#total_payments_workers").text(`$${formatNumber(response.project.total_payments_workers)}`)
						$("#average_payment_per_hour").text(`$${formatNumber(response.project.average_payment_per_hour)}`)

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
        
        $.ajax({
            type: method,
            url: action,
            data: formProjectWorkers.serialize(),
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
            success: function (response) {
                const rowIndex = dtPW.column(0).data().indexOf(response.project_worker.id.toString());
				$("#closeModal").trigger('click')
				$("#total_worked_hours").text(response.project.total_worked_hours)
				$("#total_payments_workers").text(`$${formatNumber(response.project.total_payments_workers)}`)
				$("#average_payment_per_hour").text(`$${formatNumber(response.project.average_payment_per_hour)}`)

				
				if (method == "POST") {
					let row = [
                        response.project_worker.id.toString(),
						response.project_worker.worker.name,
                        `$ ${formatNumber(response.project_worker.hourly_pay)}`,
						response.project_worker.worked_hours,
                        `$ ${formatNumber(response.project_worker.hourly_pay * response.project_worker.worked_hours)}`,
						getButtons(response.project_worker.id, response.project_worker.worker.name),
					]
                    
					dtPW.row.add(row).draw(false)
					toastr.success(`Worker ${response.project_worker.name} has been added successfully`, 'Worker added')
				}else{
					let rowData = dtPW.row(rowIndex).data();
					rowData[1] = response.project_worker.worker.name;
					rowData[2] = `$ ${formatNumber(response.project_worker.hourly_pay)}`;
					rowData[3] = response.project_worker.worked_hours;
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

	window.savePartner = () => {
		const formProjectPartners = $("#project_partnersModal-form")
		const action = formProjectPartners.attr('action')
		const method = $("#addEditModal").find('input[name="_method"]').val().toUpperCase()
        
        $.ajax({
            type: method,
            url: action,
            data: formProjectPartners.serialize(),
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
            success: function (response) {
                const rowIndex = dtPP.column(0).data().indexOf(response.project_partner.id.toString());
				$("#closeModal").trigger('click')
				console.log(response);
				
				if (method == "POST") {
					let row = [
                        response.project_partner.id.toString(),
						response.project_partner.partner.name,
                        `${(response.project_partner.percentage)}%`,
						getButtonsPartners(response.project_partner.id, response.project_partner.partner.name),
					]
                    
					dtPP.row.add(row).draw(false)
					toastr.success(`Partner ${response.project_partner.name} has been added successfully`, 'Partner added')
				}else{
					let rowData = dtPP.row(rowIndex).data();
					rowData[1] = response.project_partner.partner.name;
					rowData[2] = `${(response.project_partner.percentage)}%`;
					dtPP.row(rowIndex).data(rowData).draw(false);
					toastr.success(`Partner has been updated successfully`, 'Partner updated')
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

	function getButtonsPartners(project_partner_id, amount) {
		return `<div class="text-center">
            <a class="btn btn-primary" onclick="getAddEditModalPartner('edit', ${$("#project_id").val()} ,${project_partner_id})">
                <i class="fas fa-edit"></i>
            </a>
            <a class="btn btn-danger" onclick="showDeletePartner(${project_partner_id}, '${amount}')">
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
				$("#rest_payments").text(`$${formatNumber(response.project.rest_payments)}`)

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
						$("#rest_payments").text(`$${formatNumber(response.project.rest_payments)}`)
						
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

	window.showDeletePartner = (project_partner_id, name) => {
		const confirm = alertYesNo('Delete partner',`Are you sure to delete the partner ${name}?`);
		confirm.then((result) => {
			if (result) {
				$.ajax({
					type: "DELETE",
					url: `${getBaseUrl()}/project_partners/${project_partner_id}`,
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function (response) {
						const rowIndex = dtPP.column(0).data().indexOf(project_partner_id.toString());
						dtPP.row(rowIndex).remove().draw(false)
						toastr.success(`The partner has been deleted successfully`, 'Partner deleted')
					},
					error: function (xhr, textStatus, errorThrown) {
						toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
					},
				});
			}
		})
	}

	window.saveBill = () => {
		const formProjectBills = $("#billsModal-form")
		const action = formProjectBills.attr('action')
		const method = $("#addEditModal").find('input[name="_method"]').val().toUpperCase()
        
        $.ajax({
            type: method,
            url: action,
            data: formProjectBills.serialize(),
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
            success: function (response) {
                const rowIndex = dtBills.column(0).data().indexOf(response.bill.id.toString());
				$("#total_bills").text(`$${formatNumber(response.bill.project.total_bills)}`)

				$("#closeModal").trigger('click')

				if (method == "POST") {
					let row = [
						response.bill.id.toString(),
						response.bill.bill_type.name,
						response.bill.project_payment_type.name,
						`$${formatNumber(response.bill.amount)}`,
						formatDate(response.bill.date),
						response.bill.description,
						getButtonsBills(response.bill.id, response.bill.amount, response.bill.project.id),
					]
					dtBills.row.add(row).draw(false)
					toastr.success(`The bill has been created successfully`, 'Bill created')
				}else{
					let rowData = dtBills.row(rowIndex).data();
                    
					rowData[1] = response.bill.bill_type.name,
					rowData[2] = response.bill.project_payment_type.name,
					rowData[3] = `$${formatNumber(response.bill.amount)}`,
					rowData[4] = formatDate(response.bill.date),
					rowData[5] = response.bill.description,
					dtBills.row(rowIndex).data(rowData).draw(false);
					toastr.success(`The bill has been updated successfully`, 'Bill updated')
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
						$("#rest_payments").text(`$${formatNumber(response.project.rest_payments)}`)
						
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

	function getButtonsBills(bill_id, amount, project_id) {
		return `<div class="text-center">
					<a class="btn btn-primary" onclick="getAddEditModalBill('edit',${project_id},${bill_id})">
						<i class="fas fa-edit"></i>
					</a>
					<a class="btn btn-danger" onclick="showDeleteBill(${bill_id}, '${amount}')">
						<i class="fas fa-trash"></i>
					</a>
				</div>`
	}

	window.showDeleteBill = (bill_id, amount) => {
		
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
						const rowIndex = dtBills.column(0).data().indexOf(bill_id.toString());
						dtBills.row(rowIndex).remove().draw(false)
						$("#total_bills").text(`$${formatNumber(response.bill.project.total_bills)}`)

						toastr.success(`The bill has been deleted successfully`, 'Bill deleted')
					},
					error: function (xhr, textStatus, errorThrown) {
						toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
					},
				});
			}
		})
	}
    
    $(document).on('change', '#upload-project-picture', function (e) {
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
           	error: function (xhr, textStatus, errorThrown) {
				toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
			},
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
                    error: function (xhr, textStatus, errorThrown) {
						toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
					},
                });
            }
        })
    }

	$(document).on('change', '#upload-project-ticket', function (e) {
        const file = e.target.files[0];
        const formData = new FormData();
        formData.append('image', file);
		
        $.ajax({
            url: `${getBaseUrl()}/projects/uploadTicket/${$("#project_id").val()}`,
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
                    class: 'ticket-preview-container position-relative d-inline-block project-ticket',
                });
                previewContainer.attr('data-filename', data.name);
                previewContainer.attr('data-ticket_id', data.ticket_id);
                
                const deleteButton = $('<a>', {
                    class: 'delete-image-btn btn btn-danger btn-sm position-absolute',
                    text: 'X',
                    click: function () {
                        deleteProjectTicket(data.name, data.ticket_id)
                    }
                });

                // Ensamblar y agregar al DOM
                previewContainer.append(img).append(deleteButton);
                $('#image-ticket-preview').append(previewContainer);
            },
           	error: function (xhr, textStatus, errorThrown) {
				toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
			},
        });
    });

    window.deleteProjectTicket = (filename, ticket_id) => {
        const confirm = alertYesNo('Delete ticket',`Are you sure to delete it?`);
        confirm.then((result) => {
            if (result) {
                $.ajax({
                    url: `${getBaseUrl()}/projects/deleteTicket/${ticket_id}`,
                    method: 'DELETE',
                    data: { name: filename },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function () {
                        $('.ticket-preview-container').filter(`[data-ticket_id="${ticket_id}"]`).remove();
                    },
                   error: function (xhr, textStatus, errorThrown) {
						toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
					},
                });
            }
        })
    }

	window.copyInvoice = (invoice_id) => {
		const confirm = alertYesNo('Copy invoice',`Are you sure to copy the invoice #${invoice_id}`);
        confirm.then((result) => {
            if (result) {
                $.ajax({
                    url: `${getBaseUrl()}/invoices/copyInvoice/${invoice_id}`,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        
                        let row = [
                            response.invoice.id.toString(),
                            response.invoice.name,
                            "$" + formatNumber(response.invoice.cost),
                            "$" + formatNumber(response.invoice.total),
                            formatDate(response.invoice.date_due),
                            getUsing(response.invoice.in_use),
                            response.buttons,
                        ]
                        dtInvoices.row.add(row).draw(false)
                        $("#cost_proyected").text("$" + formatNumber(response.invoice.project.total_invoice_costs))
                        $("#total_real").val(response.invoice.project.total_invoice_prices)
                        toastr.success(`The invoice has been copied successfully`, 'Invoice copied')
                    },
                   error: function (xhr, textStatus, errorThrown) {
						toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
					},
                });
            }
        })
	}

    window.showDeleteInvoice = (invoice_id) => {
		const confirm = alertYesNo('Delete invoice',`Are you sure to delete the invoice #${invoice_id} PERMANENTLY?`);
		confirm.then((result) => {
			if (result) {
				$.ajax({
					type: "DELETE",
					url: `${getBaseUrl()}/invoices/${invoice_id}`,
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function (response) {
                        console.log(response);
                        
						const rowIndex = dtInvoices.column(0).data().indexOf(invoice_id.toString());
						dtInvoices.row(rowIndex).remove().draw(false)
                        $("#cost_proyected").text("$" + formatNumber(response.invoice.project.total_invoice_costs))
                        $("#total_real").val(response.invoice.project.total_invoice_prices)
						toastr.success(`The invoice has been deleted successfully`, 'Invoice deleted')
					},
					error: function (xhr, textStatus, errorThrown) {
						toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
					},
				});
			}
		})
	}

    function getUsing(in_use){
        if (in_use) {
            return '<span class="badge badge-success">Yes</span>'
        }else{
            return '<span class="badge badge-danger">No</span>'
        }
    }


    


})