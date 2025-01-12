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
    const formatted = parseFloat(value).toFixed(4); // Formatea a 4 decimales
    const trimmed = parseFloat(formatted).toString(); // Elimina ceros innecesarios
    return trimmed.includes('.') && trimmed.split('.')[1].length > 2
        ? trimmed
        : parseFloat(value).toFixed(2);
};

window.formatDate = (inputDate) => {
    // Dividir la fecha de entrada en componentes
    const [year, month, day] = inputDate.split('-');
    
    // Crear una nueva fecha como cadena en el formato deseado
    const formattedDate = `${month.padStart(2, '0')}/${day.padStart(2, '0')}/${year}`;
    
    return formattedDate;
}