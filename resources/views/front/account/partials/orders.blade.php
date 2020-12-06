@extends('front.account.index')

@push('partial_css')
@endpush

@section ( 'title', 'Toyota viličari - Prodaja i najam')

@section('partials_breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('moj') }}">Moj račun</a></li>
    <li class="breadcrumb-item">Narudžbe</li>
@endsection

@section('partial')
    <div class="row clearfix">

        <div class="col-lg-12">

            <div class="fancy-title notopmargin title-border">
                <h4>Moje narudžbe</h4>
            </div>

            <p>U nastavku je pregled vaših narudžbi poredan po datumu narudžbe.</p>

            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th width="25%">Datum</th>
                    <th>Aktivnost</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>
                            <code>{{ \Carbon\Carbon::make($order->created_at)->format('d.m.Y') }}</code>
                        </td>
                        <td>
                            <a href="{{ route('moj.narudzba', ['order' => $order]) }}">#{{ $order->id }}</a>
                            <span class="text-muted">Status: </span>{{ $order->status->name }}
                            <span class="text-muted"> - {{ number_format($order->total, 2, ',', '.') }} HRK</span>
                            <span class="float-right"><a href="{{ route('moj.narudzba', ['order' => $order]) }}">Detalji...</a></span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="clearfix"></div>
    {{ $orders->links('front.layouts.partials.paginate') }}
@endsection

@push('partial_js')
@endpush
