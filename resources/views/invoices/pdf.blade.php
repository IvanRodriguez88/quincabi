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

        table th, table td {
            border: 1px solid black; /* Bordes visibles */
            padding: 5px; /* Relleno dentro de las celdas */
            text-align: left; /* Alineación del texto */
            font-size: 14px;
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
            <h4>Invoice #{{$invoice->id}}</h4>
            <p>Invoice Date: {{date("d/m/Y", strtotime($invoice->date_issued))}}</p>
            <p>Due Date: {{date("d/m/Y", strtotime($invoice->date_due))}}</p>
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
                <p>{{$invoice->client->name}}</p>
                <p>{{$invoice->client->address}}</p>
                <p>{{$invoice->client->phone}}</p>
                <p>{{$invoice->client->email}}</p>
            </div>
        </div>
        <br>
        <table>
            <thead>
                <th>Description</th>
                <th style="text-align: center">Qty.</th>
                <th style="text-align: right">Unit Price</th>
                <th style="text-align: right">Total</th>
            </thead>
            <tbody>
                @foreach ($invoice->invoiceRows as $invoiceRow)
                    <tr>
                        <td>{{$invoiceRow->name}}</td>
                        <td style="text-align: center">{{$invoiceRow->amount}}</td>
                        <td style="text-align: right">$ {{number_format($invoiceRow->unit_price, 2, '.', ',')}}</td>
                        <td style="text-align: right">$ {{number_format($invoiceRow->unit_price * $invoiceRow->amount, 2, '.', ',')}}</td>
                    </tr>
                @endforeach
            </tbody>
            
        </table>
        <h3 style="text-align: right; margin-top: 10px">BALANCE DUE: ${{number_format($invoice->getTotal(), 2, '.', ',') ?? ""}}</h3>
        <p style="text-align: center">Thank you for your business!</p>
    </div>

</body>
</html>