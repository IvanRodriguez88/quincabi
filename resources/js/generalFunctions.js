window.getErrorMessages = (errors) => {
	let text = '';
	for (let field in errors) {
		text += (`<b>${field}</b> : ${errors[field]} <br>`);
	}

	return `
		<div class="card card-warning">
			<div class="card-header">
				<h3 class="card-title">Missing fields</h3>
			<div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="remove">
				<i class="fas fa-times"></i>
			</button>
		</div>
		
		</div>
			<div class="card-body">
				${text}
			</div>
		</div>
	`
}

window.getBaseUrl = function () {
	return $("#app_url").val();
}

window.formatNumber = (value) => {
	return parseFloat(value).toFixed(2);
}

window.formatDate = (inputDate) => {
    // Dividir la fecha de entrada en componentes
    const [year, month, day] = inputDate.split('-');
    
    // Crear una nueva fecha como cadena en el formato deseado
    const formattedDate = `${day.padStart(2, '0')}/${month.padStart(2, '0')}/${year}`;
    
    return formattedDate;
}