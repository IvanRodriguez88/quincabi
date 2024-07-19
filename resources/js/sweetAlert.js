window.alertYesNo = (title, text, width = 400, icon = 'question', confirmText = "Accept", cancelText = "Cancel", confirmColor = "#873336", cancelColor = "#696969") => {
	return new Promise((resolve) => {
		  Swal.fire({
			title: title,
			html: text,
			icon: icon,
			showCancelButton: true,
			confirmButtonColor: confirmColor,
			cancelButtonColor: cancelColor,
			confirmButtonText: confirmText,
			cancelButtonText: cancelText,
			width: width,
			customClass: {
				actions: 'actions-swalalert2',
			}
		  }).then((result) => {
			if (result.isConfirmed) {
			  resolve(true);
			} else {
			  resolve(false);
			}
		  });
	});
};

window.simpleAlert = (title, text, icon = 'success') => {
	Swal.fire({
		title: title,
		text: text,
		icon: icon,
		confirmButtonText: 'Aceptar',
		confirmButtonColor: '#873336',

	})
}