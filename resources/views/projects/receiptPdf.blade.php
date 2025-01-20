<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        *{
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }

        h2 {
            color: #54393a;
            margin-bottom: 5px;
            margin-top: 5px;
        }

        p, h4 {
            margin: 0;
        }

        hr {
            border: 1px solid #e3e3e3;
        }

        table {
            width: 100%;
            border-collapse: collapse; /* Colapsar bordes */
        }

       

        table th {
            background-color: #f2f2f2; /* Color de fondo para encabezados */
        }
    </style>
</head>
<body>
    <div>
        <h2><b>QuinCabinetry</b></h2>
        <div style="float: left; width: 90%">
			<h4 style="text-align: center">{{$project->name}}</h4>
        </div>
        <img style="width:60px; margin-top: -50px" src="{{public_path('vendor/adminlte/dist/img/logo-black.png')}}" alt="Logo">
    </div>
    <br>
    <hr>
    <div>
        <div>
            <div>
                <p>916 Woodland St Channelview, TX 77530</p>
                <p>quincabinetry.com</p>
                <p>(832) 530-8388</p>
                <p></p>
                <p></p>
                <br>
            </div>
            <div style="font-size: 14px">
                <p><b>BILL TO</b></p>
                <p>{{$project->client->name}}</p>
                <p>{{$project->client->address}}</p>
                <p>{{$project->client->phone}}</p>
                <p>{{$project->client->email}}</p>
            </div>
        </div>
        <br>
		<p><b>INVOICES</b></p>
		<table>
            <thead>
                <th></th>
                <th</th>
            </thead>
            <tbody>
                @foreach ($project->invoices as $invoice)
                    @if ($invoice->in_use)
						<tr>
							<td>{{$invoice->name}}</td>
							<td style="text-align: right">$ {{formatNumber($invoice->getTotal())}}</td>
						</tr>
					@endif
                @endforeach
            </tbody>
        </table>
		<br>
		<p><b>PAYMENTS</b></p>
		<table>
            <thead>
                <th></th>
				<th></th>
            </thead>
            <tbody>
                @foreach ($project->payments()->orderBy('date', 'asc')->get() as $payment)
					<tr>
						<td>{{date("m/d/Y", strtotime($payment->date)) }}</td>
						<td style="text-align: right">$ {{formatNumber($payment->amount)}}</td>
					</tr>
                @endforeach
            </tbody>
        </table>
		<br>
		<table>
			<thead>
				<th></th>
				<th></th>
			</thead>
			<tbody>
				<tr>
					<td style="text-align: right; margin-top: 10px; margin-bottom: 5px">TOTAL:</td>
					<td style="text-align: right;">
						${{formatNumber($project->totalInvoicesPrices()) ?? ""}}
					</td>
				</tr>

				<tr>
					<td style="text-align: right">PAYMENTS:</td>
					<td style="text-align: right;">
						- ${{formatNumber($project->total_payments) ?? ""}}
					</td>
				</tr>

				<tr>
					<td>
						<h3 style="text-align: right; margin-top: 5px;">BALANCE DUE:</h3>
					</td>
					<td style="text-align: right;">
						${{formatNumber($project->totalInvoicesPrices() - $project->total_payments)}}
					</td>
				</tr>
			</tbody>
		</table>
        <p style="text-align: center">Thank you for your business!</p>
    </div>

</body>
</html>