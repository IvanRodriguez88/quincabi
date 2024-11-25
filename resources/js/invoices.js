$(function () {
	let freeMaterial = false

	$.ajax({
		url: `${getBaseUrl()}/materials/getdataautocomplete`,
		type: 'GET',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
		},
		success: function(response) {
			autocomplete("material", response, "Buscar...", onSelect)
		},error: function(xhr, textStatus, errorThrown) {
			errorMessage(xhr.status, errorThrown)
		}
	});

	function onSelect() {
		$.ajax({
			url: `${getBaseUrl()}/materials/getbyid/${$("#material_id").val()}`,
			type: 'GET',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
			},
			success: function(response) {
				$("#unit_price").val(response.price)
				$("#unit_cost").val(response.cost)
				updateTotal()
			},error: function(xhr, textStatus, errorThrown) {
				errorMessage(xhr.status, errorThrown)
			}
		});
	}

	$("#client_id").on("change", function(){
		$.ajax({
			url: `${getBaseUrl()}/invoices/getclientinfo/${$(this).val()}`,
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

	function updateTotal(){
		const total = $("#amount").val()
		const price = $("#unit_price").val()

		$("#total_price").val(total * price)
	}

	$("#amount, #unit_price").on("input", function() {
		updateTotal()
	})

	window.addMaterial = () => {
		if (validateAddMaterial()) {
			const data = $("#material-form").serialize()
			console.log(data);
			
			$.ajax({
				url: `${getBaseUrl()}/invoices/addmaterial`,
				type: 'GET',
				data: data,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
				},
				success: function(response) {
					$("#material-table tbody").append(response)
					$("#total_invoice").text("$" + formatNumber(getTotalInvoice()))
					clearInputs()
					
				},error: function(xhr, textStatus, errorThrown) {
					errorMessage(xhr.status, errorThrown)
				}
			});
		}
	}

	function clearInputs(){
		$("#material_name").val("")
		$("#material_id").val("")
		$("#amount").val("1")
		$("#unit_price").val("0")
		$("#unit_cost").val("0")
		$("#total_price").val("0")
	}

	function validateAddMaterial() {
		
		if (!freeMaterial) {
			if ($("#material_id").val() == "") {
				simpleAlert("No material selected", "It is necessary to select a material", "warning")
				return false
			}
		}else{
			if ($("#free_material_input").val() == "") {
				simpleAlert("Invalid name", "The name cannot be empty", "warning")
				return false
			}
		}
		
		if ($("#amount").val() < 1) {
			simpleAlert("Invalid amount", "The minimum value is 0", "warning")
			return false
		}
		if (!$("#unit_price").val() > 0) {
			simpleAlert("Invalid price", "The minimum value is 0", "warning")
			return false
		}

		return true
		
	}

	window.deleteMaterial = (param, name) => {
		const confirm = alertYesNo('Delete material',`Are you sure to delete the material ${name}?`);
		confirm.then((result) => {
			if (result) {
				$(param).closest("tr").remove()
				$("#total_invoice").text("$" + formatNumber(getTotalInvoice()))
			}
		})
	}

	window.increase = (param) => {
		let amount = $(param).parent().find("input")
		amount.val(parseInt(amount.val()) + 1)
		amount.trigger("input")
	}

	window.decrease = (param) => {
		let amount = $(param).parent().find("input")
		if (amount.val() > 1) {
			amount.val(parseInt(amount.val()) - 1)
			amount.trigger("input")
			
		}
	}
	
	$(document).on("input", ".amount", function() {
		const tr = $(this).closest("tr")
		const amount = $(this).val()
		const unit_price = tr.find(".unit_price").val()
		
		let totalText = tr.find(".total")
		const totalInput = tr.find(".total_input")
		const total = unit_price * amount
		totalText.text("$"+formatNumber(total))
		totalInput.val(total)
		
		$("#total_invoice").text("$" + formatNumber(getTotalInvoice()))
	})

	function getTotalInvoice() {
		let total = 0
		$("#material-table tbody tr").each(function() {
			total += parseFloat($(this).find(".total_input").val())
		})
		return total
	}


	function getAllRows() {
		let rows = []
		$("#material-table tbody tr").each(function() {
			const material_id = $(this).find(".material_id").val()
			const material_name = $(this).find(".material_name").val()
			const amount = $(this).find(".amount").val()
			const cost = $(this).find(".unit_cost").val()
			const price = $(this).find(".unit_price").val()

			rows.push({material_id,material_name, amount, cost,price})
		})
		return rows
	}

	window.saveInvoice = () => {
		let data = {
			"materials": getAllRows(),
			"name": $("#name").val(),
			"date_due": $("#date_due").val(),
			"client_id": $("#client_id").val(),
			"total": getTotalInvoice()
		}

		const type = $("#type").val()
		let method = "POST"
		let url = `${getBaseUrl()}/invoices`

		if (type == "edit") {
			method = "PUT"
			url = `${getBaseUrl()}/invoices/${$("#invoice_id").val()}`
		}
		
		if (data["materials"].length > 0) {
			$.ajax({
				url: url,
				type: method,
				data: data,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
				},
				success: function(response) {
					if (response.status) {
						if (type == "edit") {
							toastr.success(`Invoice has been updated successfully`, 'Invoice updated')
						}else {
							toastr.success(`Invoice has been created successfully`, 'Invoice created')
						}
						window.location.href = (`${getBaseUrl()}/invoices`)
					}else{
						toastr.error("An error occurred", "Error")
					}
				},error: function(xhr, textStatus, errorThrown) {
					$("#error-messages").hide();
					$("#error-messages").empty().append(getErrorMessages(xhr.responseJSON.errors));
					$("#error-messages").slideDown("fast");
				}
			});
		}else {
			simpleAlert("Not enought materials", "It is necessary to add at least one material.", "warning")
		}
	}

	$("#free_check").on("change", function() {
		if ($(this).prop("checked")) {
			$("#free_material").removeClass("d-none")
			$("#search_material").addClass("d-none")
			clearInputs()
			freeMaterial = true
		}else{
			$("#free_material").addClass("d-none")
			$("#search_material").removeClass("d-none")
			$("#free_material_input").val("")
			freeMaterial = false
		}
		
	})

	
})

