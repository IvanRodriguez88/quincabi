import Highcharts from 'highcharts';
import Exporting from 'highcharts/modules/exporting';
import Accessibility from 'highcharts/modules/accessibility';

$(document).ready(function () {


	const table = $('#report_by_workers-table').DataTable();


    $('#filterButton').on('click', function () {
        const startDate = $('#start_date').val();
        const endDate = $('#end_date').val();
        const worker_id = $('#worker_id').val();

        $.ajax({
			url: `${getBaseUrl()}/report_by_workers/filterDT`,
            type: "GET",
            data: {
                start_date: startDate,
                end_date: endDate,
				worker_id: worker_id
            },
            success: function (response) {
				let workers = response.data.map(item => item[0]); // Nombre del trabajador
				let data = response.data.map(item => parseFloat(item[2].replace('$', '').replace(',', ''))); // Ganancias, eliminando "$" y comas
				let worked_hours = response.data.map(item => parseFloat(item[1]));
				
				table.clear(); // Limpia la tabla actual
				table.rows.add(response.data).draw(false); // Agrega los nuevos datos
				getChart(workers, data, worked_hours)
            },
            error: function () {
                alert('Error');
            },
        });
    });

	$("#filterButton").trigger("click")




	function getChart(workers, data, worked_hours) {
		Highcharts.chart('container', {
			chart: {
				type: 'column'
			},
			title: {
				text: 'Worker payments'
			},
			xAxis: {
				categories: workers,
				crosshair: true,
				accessibility: {
					description: 'Countries'
				}
			},
			tooltip: {
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
			series: [
				{
					name: 'Payments',
					data: data
				},
				{
					name: 'Worked hours',
					data: worked_hours
				},
			]
		});
	}
});
