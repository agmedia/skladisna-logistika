@extends('front.account.index')

@push('partial_css')
@endpush

@section ( 'title', 'Toyota viličari - Prodaja i najam')

@section('partials_breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('moj') }}">Moj račun</a></li>
    <li class="breadcrumb-item"><a href="{{ route('moj.narudzbe') }}">Narudžbe</a></li>
    <li class="breadcrumb-item">Narudžba br. {{ $order->id }}</li>
@endsection

@section('partial')
    <div class="row clearfix">

        <div class="col-lg-12">

            <div class="fancy-title notopmargin title-border">
                <h4>Narudžba br: {{ $order->id }}</h4>
            </div>

            <h4 class="text-danger"><span class="text-muted" style="margin-right: 20px;">Status narudžbe:</span>{{ $order->status->name }}</h4>

            <div class="row">
                <div class="col-md-6">
                    <h5 style="margin-bottom: 9px;">Adresa dostave</h5>
                    <p>
                        {{ $order->shipping_fname . ' ' . $order->shipping_lname }}<br>
                        {{ $order->shipping_address }}<br>
                        {{ $order->shipping_zip . ' ' . $order->shipping_city }}<br>
                    </p>
                </div>
                <div class="col-md-6">
                    <h5 style="margin-bottom: 9px;">Detalji narudžbe</h5>
                    <p>
                        <span class="text-muted">Datum narudžbe:</span> {{ \Carbon\Carbon::make($order->created_at)->format('d.m.Y') }}<br>
                        <span class="text-muted">Način plaćanja:</span> Bankovna transakcija<br>
                        <span class="text-muted">Način dostave:</span> Dostava<br>
                    </p>
                </div>
            </div>

            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="text-center" width="5%">#</th>
                    <th>Artikal</th>
                    <th class="text-center" width="5%">Kol.</th>
                    <th class="text-right" width="12%">Jed.Cijena</th>
                    <th class="text-right" width="12%">Iznos</th>
                    <th class="text-right" width="12%">Rabat</th>
                    <th class="text-right" width="12%">Ukupno</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->products as $product)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}.</td>
                        <td><a href="{{ \App\Models\Front\Product::resolveLink($product->product_id) }}">{{ $product->name }}</a></td>
                        <td class="text-center">{{ $product->quantity }}</td>
                        <td class="text-right">{{ number_format($product->org_price, 2, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($product->org_price * $product->quantity, 2, ',', '.') }}</td>
                        <td class="text-right">-{{ number_format(($product->org_price - $product->price) * $product->quantity, 2, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($product->price * $product->quantity, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
                @foreach($order->totals as $total)
                    <tr>
                        <td colspan="5" class="text-right">{{ $total->title }}</td>
                        <td colspan="2" class="text-right">{{ number_format($total->value, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="row clearfix">
                <div class="col-md-8">
                    <a href="{{ route('moj.narudzba.ponovi', ['order' => $order]) }}" class="button button-border button-border-thin"><i class="icon-cart"></i> Ponovi kupnju</a>
                    <a href="{{ route('moj.narudzba.ispis', ['order' => $order]) }}" class="button button-border button-border-thin">Ispiši račun <span class="text-muted">(PDF)</span></a>
                </div>
                <div class="col-md-4 text-right">
                    <a href="{{ route('moj.poruka.nova', ['subject' => 'Komentar narudžbe br.' . $order->id]) }}" class="button button-border button-border-thin"><i class="icon-comment1"></i> Napiši komentar</a>
                </div>
            </div>

        </div>

    </div>
@endsection

@push('partial_js')
@endpush
