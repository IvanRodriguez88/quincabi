$(function () {
	
	
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
				$("#client_info").append(response)
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
		$("#total_price").val("0")
	}

	function validateAddMaterial() {
		console.log($("#amount").val());
		
		if ($("#material_id").val() == "") {
			simpleAlert("No material selected", "It is necessary to select a material", "warning")
			return false
		}
		if ($("#amount").val() < 1) {
			simpleAlert("Invalid amount", "The minimum value is 0", "warning")
			return false
		}
		if ($("#unit_price").val() < 1) {
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
			const amount = $(this).find(".amount").val()
			const price = $(this).find(".unit_price").val()

			rows.push({material_id, amount, price})
		})
		return rows
	}

	window.saveInvoice = () => {
		let data = {
			"materials": getAllRows(),
			"date_due": $("#date_due").val(),
			"client_id": $("#client_id").val(),
			"total": getTotalInvoice()
		}
		$.ajax({
			url: `${getBaseUrl()}/invoices`,
			type: 'POST',
			data: data,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
			},
			success: function(response) {
				console.log(response);
				
				
			},error: function(xhr, textStatus, errorThrown) {
				errorMessage(xhr.status, errorThrown)
			}
		});
	}
})

