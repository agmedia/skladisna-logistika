@extends('back.layouts.backend')

@push('css_before')
    <link rel="stylesheet" href="{{ asset('css/core.edit.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('css_after')
@endpush


@section('content')
    <div class="content">

        @include('back.layouts.partials.session')

        @if (isset($rent))
            <h2 class="content-heading">Najam</h2>
            <div class="row row-deck gutters-tiny">
                <div class="col-md-4">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Najmoprimac</h3>
                        </div>
                        <div class="block-content">
                            <div class="font-size-lg text-black mb-5">{{ $rent->email }}</div>
                            <address>
                                <i class="fa fa-phone mr-5"></i> {{ $rent->mobile }}<br>
                                OIB: {{ $rent->oib }}
                            </address>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Viličar</h3>
                        </div>
                        <div class="block-content">
                            <div class="font-size-lg text-black mb-5">{{ $rent->type }}</div>
                            <address>
                                Nosivost: DO {{ $rent->weight }} T<br>
                                Visina dizanja: DO {{ $rent->height }} m<br>
                            </address>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Detalji</h3>
                        </div>
                        <div class="block-content">
                            <address>
                                Početak najma: {{ isset($rent->rent_start_date) ? \Carbon\Carbon::make($rent->rent_start_date)->format('d.m.Y') : '' }}<br>
                                Kraj najma: {{ isset($rent->rent_end_date) ? \Carbon\Carbon::make($rent->rent_end_date)->format('d.m.Y') : '' }}<br><br>
                                Lokacija: {{ $rent->location }}<br>
                                Adresa: {{ $rent->location_address }}<br><br>
                                Dostava na lokaciju: {{ $rent->on_location ? 'DA' : 'NE' }}<br>
                                Ima rampu: {{ $rent->has_ramp ? 'DA' : 'NE' }}<br><br>
                            </address>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection


@push('js_after')
    <script src="{{ asset('js/core.edit.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush
