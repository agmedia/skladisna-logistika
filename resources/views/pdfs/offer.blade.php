<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    {{--<meta name="dompdf.view" content="XYZ,0,0,1" />--}}

    <style>
        @page {
            margin: 10px;
            page-break-after: always;
        }
        * {
            font-family: "DejaVu Sans Mono", monospace;
        }
        body {
            background: #FFFFFF;
        }
        p  {
            margin: 0 0 0 0px;
        }

        #invoice {
            margin: auto;
            width: 100%;
            width: 780px;
        }

        .footer {
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            height: 90px;
            vertical-align: bottom;
        }
        .footer p {
            margin: 0 10px 0 10px;
            font-size: 11px;
        }

        .h1, .h2, .h3, .h4, .h5, .h6 {
            margin: 0 0 0 0;
        }
        .h1     {font-size: 36px; text-transform: uppercase;}
        .h2     {font-size: 30px}
        .h3     {font-size: 24px}
        .h4     {font-size: 18px}
        .h5     {font-size: 10px}
        .h6     {font-size: 6px}

        .details {
            font-size: 13px;
            margin: 0px;
            padding: 0px;
        }

        table {
            border: 0;
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }
        table th {
            background: none repeat scroll 0 0 #dbdbdb;
        }
        table > thead > tr > th,
        table > tbody > tr > th,
        table > tfoot > tr > th,
        table > thead > tr > td,
        table > tbody > tr > td,
        table > tfoot > tr > td {
            padding: 4px;
            line-height: 1.42857;
            vertical-align: top;
        }
        table tr > th {
            background-color: #EFEFEF;
            text-align: center !important;
            text-transform: uppercase;
            font-size: 12px;
            vertical-align: center !important;
        }
        table td {
            font-size: 12px;
            padding: 4px;
            line-height: 1;
        }
        table.border th,
        table.border td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        .table-striped > tbody > tr:nth-child(2n+1) {
            background-color: #f9f9f9;
        }

        .crt {
            width: 20px;
        }
        .product {
            width: 300px;
        }
        .qty {
            width: 60px;
        }
        .small {
            width: 80px;
        }


        .col-md-12 {
            width: 100%;
        }
        .col-md-11 {
            width: 91.6667%;
        }
        .col-md-10 {
            width: 83.3333%;
        }
        .col-md-9 {
            width: 75%;
        }
        .col-md-8 {
            width: 66.6667%;
        }
        .col-md-7 {
            width: 58.3333%;
        }
        .col-md-6 {
            width: 50%;
        }
        .col-md-5 {
            width: 41.6667%;
        }
        .col-md-4 {
            width: 33.3333%;
        }
        .col-md-3 {
            width: 25%;
        }
        .col-md-2 {
            width: 16.6667%;
        }
        .col-md-1 {
            width: 8.33333%;
        }

        .bg-white       {background: white !important;}
        .top10          {margin-top: 10px;}
        .top20          {margin-top: 20px;}
        .text-left      {text-align: left;}
        .text-center    {text-align: center;}
        .text-right     {text-align: right;}

        .text-light {
            color: #a5a5a5;
        }

        .text-bordo {
            color: #e3342f;
        }

        .logo {
            height: 70px;
        }
        .text-left-20 {
            margin-left: 10px;
        }

        hr.style-one {
            border: 0;
            height: 0.05em;
            background: #a5a5a5;
        }
    </style>
</head>
<body>
<div id="invoice">
    <table>
        <tr>
            <td class="col-md-3">
                <img src="{{ public_path('media/images/sl-logo.png') }}" class="logo">
            </td>
            <td class="col-md-8">
                <p class="text-right">Skladišna logistika d.o.o.</p>
                <p class="text-right text-light">10251 Hrvatski Leskovac, Ventilatorska 5A</p>

                <p class="text-right text-light">Tel: +38516536026, Fax: +38516536027</p>
                <p class="text-right text-light">OIB: 81060143905</p>
            </td>
            {{--<td class="col-md-1">
                <p class="text-right text-bordo"><span class="h5">{{ trans('invoice.iban') }}</span></p>
                <p class="text-right text-bordo"><span class="h5">{{ trans('invoice.oib') }}</span></p>

                <p class="text-right text-bordo"><span class="h5">{{ trans('invoice.phone') }}</span></p>
                <p class="text-right text-bordo"><span class="h5">{{ trans('invoice.email') }}</span></p>
            </td>--}}
        </tr>
    </table>

    <hr class="style-one">

    <table>
        <tr>
            <td class="col-md-12">
                <p class="text-right">Hrvatski Leskovac, <span class="h5">{{ date("d.m.Y",strtotime($order->created_at)) }}</span></p>
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td class="col-md-12">
                @if( ! empty($order->company))
                    <p class="text-left background-th text-left-20"><span class="h4">{{ $order->company }}</span></p>
                @endif
                <p class="text-left background-th text-left-20"><span class="h4">{{ $order->payment_fname . ' ' . $order->payment_lname }}</span></p>
                <p class="details text-left-20">{{ $order->payment_address }}</p>
                <p class="details text-left-20">{{ $order->payment_zip }} {{ $order->payment_city}}</p>
                @if( ! empty($order->oib))
                    <p class="details text-left-20"><b>OIB: </b> {{ $order->oib }}</p>
                @endif
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td class="col-md-12">
                <p class="text-center"><span class="h2">PREDRAČUN br. </span><span class="h3"><small>WEB-{{ $order->id }}/{{ date("yy",strtotime($order->created_at)) }}</small></span></p>
            </td>
        </tr>
    </table>

    <table class="border" style="margin-top: 34px">
        <tr>
            <th style="width: 15px">Rbr.</th>
            <th>Naziv dobra/usluge</th>
            <th style="width: 34px">Kol.</th>
            <th style="width: 80px">Jed.Cijena</th>
            <th style="width: 80px">Iznos</th>
            <th style="width: 80px">Rabat</th>
            <th style="width: 80px">Ukupno</th>
        </tr>

        @foreach ($order->products as $key => $product)
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td>{{ $product->name }}</td>
                <td class="text-center">{{ $product->quantity }}</td>
                <td class="text-right">{{ number_format($product->product->price, 2, ',', '.') }}</td>
                <td class="text-right">{{ number_format(($product->product->price * $product->quantity), 2, ',', '.') }}</td>
                <td class="text-right">-{{ number_format(($product->product->price - $product->price) * $product->quantity, 2, ',', '.') }}</td>
                <td class="text-right">{{ number_format($product->total, 2, ',', '.') }}</td>
            </tr>
        @endforeach

        @foreach($order->totals as $i => $total)
            <tr class="bg-white">
                <td colspan="5" class="total text-right">{{ $total->title }}</td>
                <td colspan="2" class="total text-right">{{ number_format($total->value, 2, ',', '.') }}</td>
            </tr>
        @endforeach

    </table>

    <table style="margin-top: 34px">
        <tr>
            <td class="col-md-3">
                <p class="details text-left-20">{{ 'Način plaćanja' }}: </p>
            </td>
            <td class="col-md-9">
                <p class="details text-left-20">{{ 'Bankovna transakcija' }}</p>
            </td>
        </tr>
    </table>

    <p>&nbsp;</p>
    <p class="details text-left-20">{{ 'Ovaj dokument je komercijalan i informativan, te nema elemente računa. Stoga isti ne služi u porezne svrhe. Iznos PDVa je uključen u cijenu.' }}</p>
    <p class="details text-left-20">OVO NIJE FISKALIZIRANI RAČUN</p>

</div>

<div class="footer text-center text-light">
    <hr class="style-one">
    <p class="h5"><strong>Skladišna logistika d.o.o.</strong> 10251 Hrvatski Leskovac, Ventilatorska 5A, OIB: 81060143905,<br>
    Tel: +38516536026, Fax: +38516536027, E-mail: info@skladisna-logistika.hr web: www.skladisna-logistika.hr<br>
    IBAN: RBA - HR2824840081103360295, Addiko bank d.d. - HR4425000091101472486
    </p>
    <p class="h5" style="font-size: 9px;">Trgovački sud u Zagrebu, MBS:080538301. Temeljni kapital: 920.000,00 kn uplaćen u cijelosti. Član uprave: Davor Pranić</p>
</div>

</body>
</html>
