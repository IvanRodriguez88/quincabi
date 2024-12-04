$(function () {
	const dt = $('#categories-table').DataTable();
	let itemsDelete = []

	window.save = () => {
		const formCategories = $("#categoriesModal-form")
		const action = formCategories.attr('action')
		const method = $("#addEditModal").find('input[name="_method"]').val().toUpperCase()
		let data = {
			'name' : $("#category_name").val(),
			'subcategories' : getSubcategoriesToUpdate(),
			'itemsDelete' : itemsDelete
		};


        $.ajax({
            type: method,
            url: action,
            data: data,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
            success: function (response) {
				const rowIndex = dt.column(0).data().indexOf(response.category.id.toString());
				$("#closeModal").trigger('click')
				
				if (method == "POST") {
					let row = [
						response.category.id.toString(),
						response.category.name,
						getButtons(response.category.id, response.category.name),
					]
					dt.row.add(row).draw(false)
					toastr.success(`The category ${response.category.name} has been created successfully`, 'Category created')
				}else{
					let rowData = dt.row(rowIndex).data();
					rowData[1] = response.category.name;
					dt.row(rowIndex).data(rowData).draw(false);
					toastr.success(`The category has been updated successfully`, 'Category created')
				}
            },
            error: function (xhr, textStatus, errorThrown) {
                $("#error-messages").hide();
				$("#error-messages").empty().append(getErrorMessages(xhr.responseJSON.errors));
				$("#error-messages").slideDown("fast");
            },
        });
	}

	function getSubcategoriesToUpdate(){
		let subcategories = [];
		$("#subcategories_list").find('.subcategory-order').each(function() {
			subcategories.push($(this).find('#subcategory_id').val());
		})
		return subcategories;
	}

	function getButtons(category_id, category_name) {
		return `<div class="text-center">
					<a class="btn btn-primary" onclick="getAddEditModal('edit', ${category_id})">
						<i class="fas fa-edit"></i>
					</a>
					<a class="btn btn-danger" onclick="showDelete(${category_id}, '${category_name}')">
						<i class="fas fa-trash"></i>
					</a>
				</div>`
	}

	window.getAddEditModal = (type, id) => {
		let url = `${getBaseUrl()}/categories/getaddeditmodal`
		if (id !== null){
			url = `${getBaseUrl()}/categories/getaddeditmodal/${id}`
		}
		$.ajax({
			type: "GET",
			url: url,
			data: {type: type},
			success: function (response) {
				$("#addEditModal").empty().append(response)
				$("#categoriesModal").modal('show')
			},
			error: function (xhr, textStatus, errorThrown) {
				toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
			},
		});
	}

	

	window.showDelete = (category_id, category_name) => {
		
		const confirm = alertYesNo('Delete category',`Are you sure to delete the category ${category_name}?`);
		confirm.then((result) => {
			if (result) {
				$.ajax({
					type: "DELETE",
					url: `${getBaseUrl()}/categories/${category_id}`,
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function (response) {
						
						if (response.status) {
							const rowIndex = dt.column(0).data().indexOf(category_id.toString());
							dt.row(rowIndex).remove().draw(false)
							toastr.success(response.message, 'Category deleted')
						}else{
							toastr.error(response.message, 'Error')
						}
					},
					error: function (xhr, textStatus, errorThrown) {
						toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
					},
				});
			}
		})
	}


	window.addSubcategory = () => {
		const subcategory = $("#subcategory_name")
		const category_id = $("#category_id").val()
		if (subcategory.val() != "") {
			$.ajax({
				type: "POST",
				data: {name: subcategory.val()},
				url: `${getBaseUrl()}/categories/savesubcategory/${category_id}`,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success: function (response) {
					$("#subcategories_list").append(response)
					$("#subcategories_list li:last").hide().slideDown('fast')
					subcategory.val("")
				},
				error: function (xhr, textStatus, errorThrown) {
					toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
				},
			});
		}else{
			simpleAlert("Missing Fields", "The subcategory name isn't can be null", "warning")
		}
	}

	window.selectSubcategory = (category_id) => {
		$.ajax({
			type: "GET",
			url: `${getBaseUrl()}/categories/selectsubcategory/${category_id}`,
			success: function (response) {
				$("#subcategory_id_selected").val(category_id)
				$("#category-items").empty().append(response)
				$("#category-items").hide().slideDown('slow')

			},
			error: function (xhr, textStatus, errorThrown) {
				toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
			},
		});
	}

	window.deleteSubcategory = (param) => {
		$(param).closest('li').fadeOut(400, function() {
			$(this).remove();
		});
	}

	window.deleteItem = (param) => {
		$(param).closest('li').fadeOut(400, function() {
			$(this).remove();
		});

		//Eliminar el registro
		const item_id = $(param).closest("li").find("#item_id").first().val()
		itemsDelete.push(item_id)
	}
	
	window.addItem = () => {
		const item = $("#item_name")
		const subcategory_id = $("#subcategory_id_selected").val()
		if (item.val() != "") {
			$.ajax({
				type: "POST",
				data: {name: item.val()},
				url: `${getBaseUrl()}/categories/saveItem/${subcategory_id}`,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success: function (response) {
					$("#items_list").append(response)
					$("#items_list li:last").hide().slideDown('fast')
					item.val("")
				},
				error: function (xhr, textStatus, errorThrown) {
					toastr.error(xhr.responseJSON.message, `Error ${xhr.status}`)
				},
			});
		}else{
			simpleAlert("Missing Fields", "The item name isn't can be null", "warning")
		}
	}

})

