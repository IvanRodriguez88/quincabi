window.getErrorMessages = (errors) => {
	let text = '';
	for (let field in errors) {
		text += (field + ': ' + errors[field]);
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