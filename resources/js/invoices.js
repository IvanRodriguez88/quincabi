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
					
				},error: function(xhr, textStatus, errorThrown) {
					errorMessage(xhr.status, errorThrown)
				}
			});
		}
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
		getTotalInvoice()
	})

	function getTotalInvoice() {
		$("#material-table tbody tr").each(function() {
			let total = $(this).find(".total_input")
			console.log(total.val());
			
		})
	}
})

